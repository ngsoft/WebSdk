<?php
/** @noinspection ALL */

namespace Adminer;

class Driver extends \Adminer\SqlDriver {

	static $extensions = array("SQLite3", "PDO_SQLite");
	static $jush = "sqlite";
	static $passwords = false;
	static $serverFile = true;
	// the server name is not used, the file is selected as the database
	protected $types = array(array("integer" => 0, "real" => 0, "numeric" => 0, "text" => 0, "blob" => 0));
	public $insertFunctions = array();
	// "text" => "date('now')/time('now')/datetime('now')",
	public $editFunctions = array(
		"integer|real|numeric" => "+/-",
		// "text" => "date/time/datetime",
		"text" => "||",
	);
	public $fulltextOperator = "MATCH";
	public $functions = array("hex", "length", "lower", "round", "unixepoch", "upper");
	public $grouping = array("avg", "count", "count distinct", "group_concat", "max", "min", "sum");
	/**
	 * @param array|null $tableStatus
	 * @return array
	 */
	function operators($tableStatus) {
	}
	/**
	 * @param string $server
	 * @param string $username
	 * @param string $password
	 */
	static function connect($server, $username, $password) {
	}
	/**
	 * @param Db $connection
	 */
	function __construct(\Adminer\Db $connection) {
	}
	/**
	 * @return array
	 */
	function structuredTypes() {
	}
	/**
	 * @param string $s
	 * @return string
	 */
	function quoteBinary($s) {
	}
	/**
	 * @param stdClass $field
	 * @return string
	 */
	function typeName(\stdClass $field) {
	}
	/**
	 * @return array
	 */
	function engines() {
	}
	/**
	 * @param array $table_status
	 * @return bool
	 */
	function supportsIndex(array $table_status) {
	}
	/**
	 * @param array $table_status
	 * @return bool
	 */
	function supportsAlterIndex(array $table_status) {
	}
	/**
	 * @param array $tableStatus
	 * @return bool
	 */
	function supportsAlterTable(array $tableStatus) {
	}
	/**
	 * @param string $table
	 * @return array
	 */
	function shadowTables($table) {
	}
	/**
	 * @param string $name
	 * @param array $index
	 * @param string $query
	 * @param bool $boolean
	 * @return string
	 */
	function fulltextSql($name, array $index, $query, $boolean) {
	}
	/**
	 * @param string $table
	 * @param array $rows
	 * @param array $primary
	 */
	function insertUpdate($table, array $rows, array $primary) {
	}
	/**
	 * @param string $name
	 * @param bool $is_view
	 */
	function tableHelp($name, $is_view = false) {
	}
	/**
	 * @param string $table
	 * @return array
	 */
	function checkConstraints($table) {
	}
	/**
	 * @return array
	 */
	function allFields() {
	}
}
