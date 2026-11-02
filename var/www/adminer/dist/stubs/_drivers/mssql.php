<?php
/** @noinspection ALL */

namespace Adminer;

class Driver extends \Adminer\SqlDriver {

	static $extensions = array("SQLSRV", "PDO_SQLSRV", "PDO_DBLIB");
	static $jush = "mssql";
	static $serverSocket = true;
	// PDO_DBLIB
	public $insertFunctions = array("date|time" => "getdate");
	public $editFunctions = array("int|decimal|real|float|money|datetime" => "+/-", "char|text" => "+");
	public $functions = array("len", "lower", "round", "upper");
	public $grouping = array("avg", "count", "count distinct", "max", "min", "sum");
	public $generated = array("PERSISTED", "VIRTUAL");
	public $onActions = "NO ACTION|CASCADE|SET NULL|SET DEFAULT";
	public $inout = "|OUTPUT";
	// types of the server which Adminer doesn't know, they are offered without a group
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
	function types() {
	}
	/**
	 * @return array
	 */
	function structuredTypes() {
	}
	/**
	 * @param stdClass $field
	 * @return string
	 */
	function typeName(\stdClass $field) {
	}
	/**
	 * @param string $table
	 * @param array $rows
	 * @param array $primary
	 */
	function insertUpdate($table, array $rows, array $primary) {
	}
	function begin() {
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
	 * @param string $s
	 * @return string
	 */
	function quoteBinary($s) {
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
	 * @param string $db
	 * @param string $schema
	 * @return bool
	 */
	function isSystem($db, $schema = "") {
	}
}
