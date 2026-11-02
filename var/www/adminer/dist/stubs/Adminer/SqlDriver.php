<?php
/** @noinspection ALL */

namespace Adminer;

abstract class SqlDriver {

	/** @var ?Driver */
	static $instance;
	/** @var string[] */
	static $drivers = array();
	// all available drivers
	/** @var list<string> */
	static $extensions = array();
	// possible extensions in the current driver
	/** @var string */
	static $jush;
	// JUSH identifier
	/** @var bool */
	static $passwords = true;
	// false in databases without passwords, they can be protected only by a plugin
	/** @var list<string> */
	static $serverSchemes = array();
	// URL schemes allowed in the server name
	/** @var list<int> */
	static $serverPorts = array();
	// privileged ports used by the protocol of the driver
	/** @var bool */
	static $serverSocket = false;
	// the server name can specify a socket
	/** @var bool */
	static $serverPath = false;
	// the server name can contain a path
	/** @var bool */
	static $serverFile = false;
	// the server name is a path to a file, not an address
	/** @var Db */
	protected $conn;
	/** @var int[][] */
	protected $types = array();
	// [$group => [$type => $maximum_unsigned_length, ...], ...]
	/** @var string */
	public $delimiter = ";";
	// string separating queries, it is used also as a regular expression
	/** @var string[] */
	public $insertFunctions = array();
	// ["$type|$type2" => "$function/$function2"] functions used in edit and insert
	/** @var string[] */
	public $editFunctions = array();
	// ["$type|$type2" => "$function/$function2"] functions used in edit only
	/** @var list<string> */
	public $unsigned = array();
	// number variants
	/** @var string */
	public $fulltextOperator = "AGAINST";
	// printed in the fulltext search box
	/** @var list<string> */
	public $functions = array();
	// functions used in select
	/** @var list<string> */
	public $grouping = array();
	// grouping functions used in select
	/** @var string */
	public $onActions = "RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";
	// used in foreign_keys()
	/** @var list<string> */
	public $partitionBy = array();
	// supported partitioning types
	/** @var string */
	public $inout = "IN|OUT|INOUT";
	// used in routines
	/** @var string */
	public $enumLength = "'(?:''|[^'\\\\]|\\\\.)*'";
	// regular expression for parsing enum lengths
	/** @var list<string> */
	public $generated = array();
	// allowed types of generated columns
	/** @var string */
	public $primary = "";
	// name of the field identifying a row in drivers without a schema, they compute the fields from the data
	/** @var string */
	public $query = "";
	// query executed by the last select(), the callers not printing it can print it later
	/** Get the JUSH module of the driver; plugin drivers are not compiled so they carry it inline
	 * @return string JavaScript code, empty if the module is merged into jush.js
	 */
	static function jushModule() {
	}
	/** Get JavaScript expression creating the autocompleter of the query <textarea>, empty if the driver has none
	 * @param TableStatus[] $tables
	 * @param list<string>|null $statements statements offered at the beginning of a query, null for all
	 * @return string
	 */
	static function jushAutocomplete(array $tables, $statements) {
	}
	/** Connect to the database
	 * @param string $server
	 * @param string $username
	 * @param string $password
	 * @return Db|string string for error
	 */
	static function connect($server, $username, $password) {
	}
	/** Forget the logged user
	 * @return void
	 */
	static function disconnect() {
	}
	/** Create object for performing database operations
	 * @param Db $connection
	 */
	function __construct(\Adminer\Db $connection) {
	}
	/** Get all types
	 * @return int[] [$type => $maximum_unsigned_length, ...]
	 */
	function types() {
	}
	/** Get structured types
	 * @return array<list<string>|string> [$description => [$type, ...], ...], a value which is not an array is a type without a description
	 */
	function structuredTypes() {
	}
	/** Get enum values
	 * @param Field $field
	 * @return string|void
	 */
	function enumLength(array $field) {
	}
	/** Function used to convert the value inputted by user
	 * @param Field $field
	 * @return string|void
	 */
	function unconvertFunction(array $field) {
	}
	/** Select data from table
	 * @param list<string> $select result of adminer()->selectColumnsProcess()[0]
	 * @param list<string> $where result of adminer()->selectSearchProcess()
	 * @param list<string> $group result of adminer()->selectColumnsProcess()[1]
	 * @param list<string> $order result of adminer()->selectOrderProcess()
	 * @param int $limit result of adminer()->selectLimitProcess()
	 * @param int $page index of page starting at zero
	 * @param bool $print whether to print the query
	 * @param string $table
	 * @return Result|bool
	 * @uses $_GET["next"] drivers with support("cursor") ignore $page, they get the cursor of the selected page here and set it to the cursor of the following page, "" if there is none
	 */
	function select($table, array $select, array $where, array $group, array $order = array(), int $limit = 1, ?int $page = 0, bool $print = false) {
	}
	/** Delete data from table
	 * @param string $queryWhere " WHERE ..."
	 * @param int $limit 0 or 1
	 * @param string $table
	 * @return Result|bool
	 */
	function delete($table, $queryWhere, $limit = 0) {
	}
	/** Update data in table
	 * @param string[] $set escaped columns in keys, quoted data in values
	 * @param string $queryWhere " WHERE ..."
	 * @param int $limit 0 or 1
	 * @param string $table
	 * @param string $separator
	 * @return Result|bool
	 */
	function update($table, array $set, $queryWhere, $limit = 0, $separator = "\n") {
	}
	/** Insert data into table
	 * @param string[] $set escaped columns in keys, quoted data in values
	 * @param string $table
	 * @return Result|bool
	 */
	function insert($table, array $set) {
	}
	/** Get RETURNING clause for INSERT queries (PostgreSQL specific)
	 * @param string $table
	 * @return string
	 */
	function insertReturning($table) {
	}
	/** Insert or update data in table
	 * @param list<string[]> $rows of arrays with escaped columns in keys and quoted data in values
	 * @param int[] $primary column names in keys
	 * @param string $table
	 * @return Result|bool
	 */
	function insertUpdate($table, array $rows, array $primary) {
	}
	/** Begin transaction
	 * @return bool
	 */
	function begin() {
	}
	/** Commit transaction
	 * @return bool
	 */
	function commit() {
	}
	/** Rollback transaction
	 * @return bool
	 */
	function rollback() {
	}
	/** Return query with a timeout
	 * @param int $timeout seconds
	 * @param string $query
	 * @return string|void null if the driver doesn't support query timeouts
	 */
	function slowQuery($query, $timeout) {
	}
	/** Get operators usable in select
	 * @param ?TableStatus $tableStatus null in the search through all tables
	 * @return list<string> a list for a single table must be a superset of the general one
	 */
	function operators($tableStatus) {
	}
	/** Convert column to be searchable
	 * @param string $idf escaped column name
	 * @param array{op:string, val:string} $val
	 * @param Field $field
	 * @return string
	 */
	function convertSearch($idf, array $val, array $field) {
	}
	/** Convert value returned by database to actual value
	 * @param array{type: string} $field
	 * @param string|null $val
	 * @return string|null
	 */
	function value($val, array $field) {
	}
	/** Quote binary string
	 * @param string $s
	 * @return string
	 */
	function quoteBinary($s) {
	}
	/** Get SQL computing the hexadecimal MD5 of a column, used to identify a row by a value too long for the URL
	 * @param Field $field
	 * @param string $column
	 * @return string|void null if the column can't be hashed
	 */
	function md5($column, array $field) {
	}
	/** Get type name of a result column in the same vocabulary as Field::type
	 * @param ResultField $field result of Result::fetch_field()
	 * @return string "" if unknown
	 */
	function typeName(\stdClass $field) {
	}
	/** Get warnings about the last command
	 * @return string|void HTML
	 */
	function warnings() {
	}
	/** Get help link for table
	 * @param string $name
	 * @param bool $is_view
	 * @return string|void relative URL
	 */
	function tableHelp($name, $is_view = false) {
	}
	/** Get tables this table inherits from
	 * @param string $table
	 * @return list<array{table: string, ns: string}>
	 */
	function inheritsFrom($table) {
	}
	/** Get inherited tables
	 * @param string $table
	 * @return list<array{table: string, ns: string}>
	 */
	function inheritedTables($table) {
	}
	/** Get partitions info
	 * @param string $table
	 * @return Partitions
	 */
	function partitionsInfo($table) {
	}
	/** Check if C-style escapes are supported
	 * @return bool
	 */
	function hasCStyleEscapes() {
	}
	/** Check whether found_rows() is only an estimate which should be recounted in small tables
	 * @return bool
	 */
	function hasEstimatedRows() {
	}
	/** Check whether a database or schema belongs to the system
	 * @param string $db
	 * @param string $schema
	 * @return bool
	 */
	function isSystem($db, $schema = "") {
	}
	/** Get regular expression matching the start of a line comment; must not match an empty string
	 * @return string
	 */
	function lineComment() {
	}
	/** Get supported engines
	 * @return list<string>
	 */
	function engines() {
	}
	/** Check whether table supports indexes
	 * @param TableStatus $table_status
	 * @return bool
	 */
	function supportsIndex(array $table_status) {
	}
	/** Check whether table indexes can be altered
	 * @param TableStatus $table_status
	 * @return bool
	 */
	function supportsAlterIndex(array $table_status) {
	}
	/** Check whether the table definition can be altered
	 * @param TableStatus $tableStatus
	 * @return bool
	 */
	function supportsAlterTable(array $tableStatus) {
	}
	/** Return list of supported index algorithms, first one is default
	 * @param TableStatus $tableStatus
	 * @return list<string>
	 */
	function indexAlgorithms(array $tableStatus) {
	}
	/** Get operator classes usable in indexes
	 * @return list<string>
	 */
	function indexOpclasses() {
	}
	/** Get tables used internally by a table
	 * @param string $table
	 * @return list<array{table: string, ns: string}>
	 */
	function shadowTables($table) {
	}
	/** Get triggers executing a trigger function
	 * @param string $name
	 * @return list<array{ns: string, table: string, trigger: string}>
	 */
	function routineTriggers($name) {
	}
	/** Get a condition for a fulltext search
	 * @param string $name index name
	 * @param Index $index
	 * @param string $query
	 * @param bool $boolean
	 * @return string
	 */
	function fulltextSql($name, array $index, $query, $boolean) {
	}
	/** Get defined check constraints
	 * @param string $table
	 * @return string[] [$name => $clause]
	 */
	function checkConstraints($table) {
	}
	/** Get all fields in the current schema
	 * @return array<list<array{field:string, null:bool, type:string, length:?numeric-string}>> optionally also 'primary'
	 */
	function allFields() {
	}
}
