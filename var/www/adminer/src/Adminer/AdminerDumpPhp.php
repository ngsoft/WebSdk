<?php

namespace Adminer;

/** Dump to PHP format.
 * @author Martin Zeman (Zemistr), http://www.zemistr.eu/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerDumpPhp
{
    public $output            = [];
    public $shutdown_callback = false;

    public function dumpFormat()
    {
        return ['php' => 'PHP'];
    }

    public function dumpHeaders()
    {
        if ('php' == $_POST['format'])
        {
            header('Content-Type: text/plain; charset=utf-8');
            return $this->checkOutput('php');
        }
    }

    public function dumpTable($table, $style, $is_view = 0)
    {
        if ('php' == $_POST['format'])
        {
            $this->output[$table] = [];

            if ( ! $this->shutdown_callback)
            {
                $this->shutdown_callback = true;
                register_shutdown_function([$this, '_export']);
            }
            return true;
        }
    }

    public function dumpData($table, $style, $query)
    {
        if ('php' == $_POST['format'])
        {
            $connection = connection();
            $result     = $connection->query($query, 1);

            if ($result)
            {
                while ($row = $result->fetch_assoc())
                {
                    $this->output[$table][] = $row;
                }
            }
            return true;
        }
    }

    public function _export()
    {
        echo '<?php return ' . var_export($this->output, true) . ';';
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
