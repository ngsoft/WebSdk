<?php

namespace Adminer;

/**
 * dump to MARKDOWN format.
 *
 * @see https://github.com/fthiella/adminer-plugin-dump-markdown
 *
 * @author Federico Thiella, https://fthiella.github.io/
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerDumpMarkdown
{
    private $type   = 'markdown';
    private $format = 'MD';

    private $markdown_chr;

    private $rowSampleLimit;
    private $nullValue;

    private $specialChars;
    private $disableUTF8;

    private $mbStrAvailable;

    public function __construct($config = [])
    {
        $this->rowSampleLimit = var_get('rowSampleLimit', $config, 100);
        $this->nullValue      = var_get('nullValue', $config, 'N/D');
        $this->specialChars   = var_get('specialChars', $config, '\*_[](){}+-#.!|');
        $this->markdown_chr   = var_get('markdown_chr', $config, ['space' => ' ', 'table' => '|', 'header' => '-']);
        $this->disableUTF8    = var_get('disableUTF8', $config, false);
        $this->mbStrAvailable = extension_loaded('mbstring');
    }

    public function _getStringLength($value)
    {
        if ($this->disableUTF8 || ! $this->mbStrAvailable)
        {
            return strlen($value);
        }
        return mb_strlen($value, 'UTF-8');
    }

    public function _getStrPos($special, $chr)
    {
        if ($this->disableUTF8 || ! $this->mbStrAvailable)
        {
            return strpos($special, $chr);
        }
        return mb_strpos($special, $chr);
    }

    public function _getSubString($value, $start, $length)
    {
        if ($this->disableUTF8 || ! $this->mbStrAvailable)
        {
            return substr($value, $start, $length);
        }
        return mb_substr($value, $start, $length, 'UTF-8');
    }

    public function _escape_markdown($value)
    {
        $escaped_value = '';

        $value         = strval($value);

        if ($this->disableUTF8)
        {
            $value = utf8_decode($value);
        }

        for ($i = 0; $i < $this->_getStringLength($value); ++$i)
        {
            $char = $this->_getSubString($value, $i, 1);

            if (false !== $this->_getStrPos($this->specialChars, $char))
            {
                $escaped_value .= '\\' . $char;
            } else
            {
                $escaped_value .= $char;
            }
        }

        return $escaped_value;
    }

    public function _process_value($value)
    {
        if (null === $value)
        {
            return $this->nullValue;
        }
        return $this->_escape_markdown($value);
    }

    public function _format_value($s, $l, $c)
    {
        return ($this->_getStringLength($s) > $l) ? $this->_getSubString($s, 0, $l) : $s . str_repeat($c, $l - $this->_getStringLength($s));
    }

    public function _map($array, $width, $c)
    {
        foreach ($array as $k => &$v)
        {
            $v = $this->_format_value($v, $width[$k], $c);
        }
        return $array;
    }

    public function _map_header($array)
    {
        foreach ($array as $k => &$v)
        {
            $v = $this->_process_value($k);
        }
        return $array;
    }

    public function _map_mtable($array)
    {
        foreach ($array as $k => &$v)
        {
            $v = $this->markdown_chr['header'];
        }
        return $array;
    }

    public function _markdown_row($row, $column_width, $separator, $filler)
    {
        return implode($separator, $this->_map($row, $column_width, $filler));
    }

    public function _markdown_table($rows, $column_width)
    {
        $content = $this->_markdown_row($this->_map_header($rows[0]), $column_width, $this->markdown_chr['space'] . $this->markdown_chr['table'] . $this->markdown_chr['space'], $this->markdown_chr['space']) . "\n";
        $content .= $this->_markdown_row($this->_map_mtable($rows[0]), $column_width, $this->markdown_chr['header'] . $this->markdown_chr['table'] . $this->markdown_chr['header'], $this->markdown_chr['header']) . "\n";

        foreach ($rows as $row)
        {
            $content .= $this->_markdown_row($row, $column_width, $this->markdown_chr['space'] . $this->markdown_chr['table'] . $this->markdown_chr['space'], $this->markdown_chr['space']) . "\n";
        }
        return $content;
    }

    public function _bool($value)
    {
        return 1 == $value ? 'Yes' : 'No';
    }

    public function dumpFormat()
    {
        return [$this->type => $this->format];
    }

    public function dumpDatabase($db)
    {
        if ($_POST['format'] == $this->format)
        {
            echo '# ' . $this->_escape_markdown($db) . "\n\n";
            return true;
        }
    }

    /* export table structure */
    public function dumpTable($table, $style, $is_view = false)
    {
        if ($_POST['format'] == $this->type)
        {
            echo '## ' . $this->_escape_markdown($table) . "\n\n";

            if ($style)
            {
                echo "### table structure\n\n";

                $field_rows  = [];
                $field_width = ['Column name' => 11, 'Type' => 4, 'Comment' => 7, 'Null' => 4, 'AI' => 2];

                foreach (fields($table) as $field)
                {
                    $new_row      = [
                        'Column name' => $this->_process_value($field['field']),
                        'Type'        => $field['full_type'],
                        'Comment'     => $field['comment'],
                        'Null'        => $this->_bool($field['null']),
                        'AI'          => $this->_bool($field['auto_increment']),
                    ];
                    $field_rows[] = $new_row;

                    foreach ($new_row as $key => $val)
                    {
                        $field_width[$key] = max($field_width[$key], $this->_getStringLength($new_row[$key]));
                    }
                }
                echo $this->_markdown_table($field_rows, $field_width);
                echo "\n";
            }
            return true;
        }
    }

    /* export table data */
    public function dumpData($table, $style, $query)
    {
        if ($_POST['format'] == $this->type)
        {
            echo "### Table Data\n\n";

            $connection = connection();

            $result     = $connection->query($query, 1);

            if ($result)
            {
                $rn           = 0;
                $sample_rows  = [];
                $column_width = [];

                while ($raw_row = $result->fetch_assoc())
                {
                    // process row for output
                    $row = [];

                    foreach ($raw_row as $key => $value)
                    {
                        $row[$key] = $this->_process_value($value);
                    }

                    // end process row
                    switch (true)
                    {
                        case 0   == $rn:
                            foreach ($row as $key => $val)
                            {
                                $column_width[$key] = $this->_getStringLength($this->_process_value($key)); // escape here?
                            }
                            // no break
                        case $rn < $this->rowSampleLimit:
                            $sample_rows[$rn] = $row;

                            foreach ($row as $key => $val)
                            {
                                $column_width[$key] = max($column_width[$key], $this->_getStringLength($row[$key]));
                            }
                            break;
                        case $rn == $this->rowSampleLimit:
                            echo $this->_markdown_table($sample_rows, $column_width);
                            // no break
                        default:
                            echo $this->_markdown_row($row, $column_width, $this->markdown_chr['space'] . $this->markdown_chr['table'] . $this->markdown_chr['space'], $this->markdown_chr['space']) . "\n";
                    }
                    ++$rn;
                }

                if ($rn <= $this->rowSampleLimit)
                {
                    echo $this->_markdown_table($sample_rows, $column_width);
                }
                echo "\n";
            }
            return true;
        }
    }

    public function dumpHeaders($identifier, $multi_table = false)
    {
        if ($_POST['format'] == $this->type)
        {
            header('Content-Type: text/markdown; charset=utf-8');
            return $this->checkOutput('md');
        }
    }

    private function checkOutput($ext)
    {
        if ('gz' === var_get('output', $_POST))
        {
            header('Content-Type: application/x-gzip; charset=utf-8');
            ob_start(function ($string)
            {
                return gzencode($string);
            }, 1e6);
        }
        return $ext;
    }
}
