<?php

namespace Adminer;

/** Dump to JSON format
 * @link https://www.adminer.org/plugins/#use
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerDumpJson
{
    /** @access protected */
    var $database = false;


    function dumpFormat()
    {
        return array('json' => 'JSON');
    }

    function dumpTable($table, $style, $is_view = 0)
    {
        if ($_POST["format"] == "json") {
            return true;
        }
    }

    function _database()
    {
        echo "}\n";
    }

    function dumpData($table, $style, $query)
    {
        if ($_POST["format"] == "json") {
            if ($this->database) {
                echo ",\n";
            } else {
                $this->database = true;
                echo "{\n";
                register_shutdown_function(array($this, '_database'));
            }
            $connection = connection();
            $result = $connection->query($query, 1);
            if ($result) {
                echo '"' . addcslashes($table, "\r\n\"\\") . "\": [\n";
                $first = true;
                while ($row = $result->fetch_assoc()) {
                    echo($first ? "" : ", ");
                    $first = false;
                    foreach ($row as $key => $val) {
                        json_row($key, $val);
                    }
                    json_row("");
                }
                echo "]";
            }
            return true;
        }
    }

    private function checkOutput($ext)
    {

        if ($_POST["output"] === 'gz') {
            header('Content-Type: application/x-gzip; charset=utf-8');
            ob_start(function ($string) {
                return gzencode($string);
            }, 1e6);
        }
        return $ext;
    }

    function dumpHeaders($identifier, $multi_table = false)
    {
        if ($_POST["format"] == "json") {
            header("Content-Type: application/json; charset=utf-8");
            return $this->checkOutput("json");
        }
    }
}
