<?php
/** @noinspection ALL */

namespace Adminer;

class Driver extends \Adminer\SqlDriver {

	static $extensions = array("PgSQL", "PDO_PgSQL");
	static $jush = "pgsql";
	static $serverSocket = true;
	// the socket directory is used as the host
	public $functions = array("char_length", "lower", "round", "to_hex", "to_timestamp", "upper");
	public $grouping = array("avg", "count", "count distinct", "max", "min", "sum");
	/**
	 * @var string
	 */
	public $nsOid = "(SELECT oid FROM pg_namespace WHERE nspname = current_schema())";
	// [$name => $oid]
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
	function enumLength(array $field) {
	}
	/**
	 * @param array $types
	 * @return void
	 */
	function setUserTypes(array $types) {
	}
	/**
	 * @param string $table
	 * @return string
	 */
	function insertReturning($table) {
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
	function inheritsFrom($table) {
	}
	/**
	 * @param string $table
	 * @return array
	 */
	function inheritedTables($table) {
	}
	/**
	 * @param string $table
	 * @return array
	 */
	function partitionsInfo($table) {
	}
	/**
	 * @param string $name
	 * @return array
	 */
	function routineTriggers($name) {
	}
	/**
	 * @param string $table
	 * @return string
	 */
	function tableOid($table) {
	}
	/**
	 * @return array
	 */
	function allFields() {
	}
	/**
	 * @param array $tableStatus
	 * @return array
	 */
	function indexAlgorithms(array $tableStatus) {
	}
	/**
	 * @return array
	 */
	function indexOpclasses() {
	}
	/**
	 * @param array $table_status
	 * @return bool
	 */
	function supportsIndex(array $table_status) {
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
}
