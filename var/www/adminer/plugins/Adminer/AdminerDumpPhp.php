<?php

namespace Adminer;

/** Dump to PHP format
 * @author Martin Zeman (Zemistr), http://www.zemistr.eu/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerDumpPhp
{
	var $output = array();
	var $shutdown_callback = false;

	function dumpFormat()
	{
		return array('php' => 'PHP');
	}

	function dumpHeaders()
	{
		if ($_POST['format'] == 'php') {
			header('Content-Type: text/plain; charset=utf-8');
			return 'php';
		}
	}

	function dumpTable($table, $style, $is_view = 0)
	{
		if ($_POST['format'] == 'php') {
			$this->output[$table] = array();
			if (!$this->shutdown_callback) {
				$this->shutdown_callback = true;
				register_shutdown_function(array($this, '_export'));
			}
			return true;
		}
	}

	function dumpData($table, $style, $query)
	{
		if ($_POST['format'] == 'php') {
			$connection = connection();
			$result = $connection->query($query, 1);
			if ($result) {
				while ($row = $result->fetch_assoc()) {
					$this->output[$table][] = $row;
				}
			}
			return true;
		}
	}

	function _export()
	{
		echo "<?php\nreturn " . var_export($this->output, true) . ";";
	}
}
