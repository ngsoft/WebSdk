<?php
/** @noinspection ALL */

namespace Adminer;

class Driver extends \Adminer\SqlDriver {

	static $extensions = array("MySQLi", "MySQL", "PDO_MySQL");
	static $jush = "sql";
	// JUSH identifier
	static $serverSocket = true;
	public $unsigned = array("unsigned", "zerofill", "unsigned zerofill");
	public $functions = array("char_length", "date", "from_unixtime", "lower", "round", "floor", "ceil", "sec_to_time", "time_to_sec", "upper");
	public $grouping = array("avg", "count", "count distinct", "group_concat", "max", "min", "sum");
	public $partitionBy = array("HASH", "LINEAR HASH", "KEY", "LINEAR KEY", "RANGE", "LIST");
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
	 * @param array $field
	 */
	function unconvertFunction(array $field) {
	}
	/**
	 * @param string $table
	 * @param array $set
	 */
	function insert($table, array $set) {
	}
	/**
	 * @param string $table
	 * @param array $rows
	 * @param array $primary
	 */
	function insertUpdate($table, array $rows, array $primary) {
	}
	/**
	 * @param string $query
	 * @param int $timeout
	 */
	function slowQuery($query, $timeout) {
	}
	/** Convert column to the value displayed in select
	 * @param string $idf escaped column name
	 * @param Field $field
	 * @return string empty if the value is displayed as it is stored
	 */
	function convertColumn($idf, array $field) {
	}
	/**
	 * @param string $idf
	 * @param array $val
	 * @param array $field
	 * @return string
	 */
	function convertSearch($idf, array $val, array $field) {
	}
	/**
	 * @param stdClass $field
	 * @return string
	 */
	function typeName(\stdClass $field) {
	}
	/**
	 * @param string $s
	 * @return string
	 */
	function quoteBinary($s) {
	}
	/**
	 * @param string $column
	 * @param array $field
	 */
	function md5($column, array $field) {
	}
	function warnings() {
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
	function partitionsInfo($table) {
	}
	/** @return string[]
	 * @param string $table
	 */
	function checkConstraints($table) {
	}
	/**
	 * @return bool
	 */
	function hasCStyleEscapes() {
	}
	/**
	 * @return bool
	 */
	function hasEstimatedRows() {
	}
	/**
	 * @param string $db
	 * @param string $schema
	 * @return bool
	 */
	function isSystem($db, $schema = "") {
	}
	/**
	 * @return string
	 */
	function lineComment() {
	}
	/**
	 * @return array
	 */
	function engines() {
	}
	/**
	 * @param array $tableStatus
	 * @return array
	 */
	function indexAlgorithms(array $tableStatus) {
	}
}
