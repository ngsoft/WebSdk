<?php

namespace Adminer;

/** Dump to JSON format.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerDumpJson
{
    public $database = false;

    public function dumpFormat()
    {
        return ['json' => 'JSON'];
    }

    public function dumpTable($table, $style, $is_view = 0)
    {
        if ('json' == $_POST['format'])
        {
            return true;
        }
    }

    public function _database()
    {
        echo "}\n";
    }

    public function dumpData($table, $style, $query)
    {
        if ('json' == $_POST['format'])
        {
            if ($this->database)
            {
                echo ",\n";
            } else
            {
                $this->database = true;
                echo "{\n";
                register_shutdown_function([$this, '_database']);
            }
            $connection = connection();
            $result     = $connection->query($query, 1);

            if ($result)
            {
                echo '"' . addcslashes($table, "\r\n\"\\") . "\": [\n";
                $first = true;

                while ($row = $result->fetch_assoc())
                {
                    echo $first ? '' : ', ';
                    $first = false;

                    foreach ($row as $key => $val)
                    {
                        json_row($key, $val);
                    }
                    json_row('');
                }
                echo ']';
            }
            return true;
        }
    }

    public function dumpHeaders($identifier, $multi_table = false)
    {
        if ('json' == $_POST['format'])
        {
            header('Content-Type: application/json; charset=utf-8');
            return $this->checkOutput('json');
        }
    }

    private function checkOutput($ext)
    {
        if ('gz' === $_POST['output'])
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
