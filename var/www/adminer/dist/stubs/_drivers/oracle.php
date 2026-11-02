<?php
/** @noinspection ALL */

namespace Adminer;

class Driver extends \Adminer\SqlDriver {

	static $extensions = array("OCI8", "PDO_OCI");
	static $jush = "oracle";
	static $serverPath = true;
	// the service name in the Easy Connect syntax
	public $insertFunctions = array(
		//! no parentheses
		"date" => "current_date",
		"timestamp" => "current_timestamp",
	);
	public $editFunctions = array("number|float|double" => "+/-", "date|timestamp" => "+ interval/- interval", "char|clob" => "||");
	public $functions = array("length", "lower", "round", "upper");
	public $grouping = array("avg", "count", "count distinct", "max", "min", "sum");
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
	//! support empty $set in insert()
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
	/**
	 * @param stdClass $field
	 * @return string
	 */
	function typeName(\stdClass $field) {
	}
	/**
	 * @return bool
	 */
	function hasCStyleEscapes() {
	}
	/**
	 * @param string $table
	 * @param array $select
	 * @param array $where
	 * @param array $group
	 * @param array $order
	 */
	function select($table, array $select, array $where, array $group, array $order = array(), int $limit = 1, ?int $page = 0, bool $print = false) {
	}
	/**
	 * @return array
	 */
	function allFields() {
	}
}
