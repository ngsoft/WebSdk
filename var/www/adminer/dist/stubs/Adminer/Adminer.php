<?php
/** @noinspection ALL */

namespace Adminer;

// any method change in this file should be transferred to editor/include/adminer.inc.php
/** Default Adminer plugin; it should call methods via adminer()->f() instead of $this->f() to give chance to other plugins */
class Adminer {

	/** @var Adminer|Plugins|null */
	static $instance;
	/** @visibility protected(set)
	 * @var string
	 */
	public $error = '';
	// HTML
	/** Name in title and navigation
	 * @return string HTML code
	 */
	function name() {
	}
	/** Connection parameters
	 * @return array{string, string, string}
	 */
	function credentials() {
	}
	/** Get SSL connection options
	 * @return string[]|void
	 */
	function connectSsl() {
	}
	/** Get key used for permanent login
	 * @param bool $create
	 * @return string cryptic string which gets combined with password or '' in case of an error
	 */
	function permanentLogin($create = false) {
	}
	/** Return key used to group brute force attacks; behind a reverse proxy, you want to return the last part of X-Forwarded-For
	 * @return string
	 */
	function bruteForceKey() {
	}
	/** Decide whether to require the CSRF token when logging in, a form on another website doesn't have it
	 * @return bool
	 */
	function verifyLoginToken() {
	}
	/** Get server name displayed in breadcrumbs
	 * @param string|null $server
	 * @return string HTML code or null
	 */
	function serverName($server) {
	}
	/** Identifier of selected database
	 * @return string|null
	 */
	function database() {
	}
	/** Get list of databases
	 * @param bool $flush
	 * @return list<string>
	 */
	function databases($flush = true) {
	}
	/** Print links after list of plugins
	 * @return void
	 */
	function pluginsLinks() {
	}
	/** Operators used in select
	 * @param ?TableStatus $tableStatus null in the search through all tables
	 * @return list<string> operators
	 */
	function operators(array $tableStatus = null) {
	}
	/** Get list of schemas
	 * @return list<string>
	 */
	function schemas() {
	}
	/** Specify limit for waiting on some slow queries like DB list
	 * @return float number of seconds
	 */
	function queryTimeout() {
	}
	/** Called after connecting and selecting a database
	 * @return void
	 */
	function afterConnect() {
	}
	/** Headers to send before HTML output
	 * @return void
	 */
	function headers() {
	}
	/** Get Content Security Policy headers
	 * @param list<string[]> $csp of arrays with directive name in key, allowed sources in value
	 * @return list<string[]> same as $csp
	 */
	function csp(array $csp) {
	}
	/** Decide whether to check for a new Adminer version
	 * @return bool
	 */
	function verifyVersion() {
	}
	/** Print the script maintaining the service worker
	 * @return void
	 */
	function serviceWorker() {
	}
	/** Get the web app manifest allowing to install Adminer as an application, empty array to not offer it
	 * @return mixed[]
	 */
	function manifest() {
	}
	/** Print HTML code inside <head>
	 * @param bool $dark dark CSS: false to disable, true to force, null to base on user preferences
	 * @return bool true to link favicon.ico
	 */
	function head($dark = null) {
	}
	/** Print extra classes in <body class>; must start with a space
	 * @return void
	 */
	function bodyClass() {
	}
	/** Get URLs of the CSS files
	 * @return string[] key is URL, value is either 'light' (supports only light color scheme), 'dark' or '' (both)
	 */
	function css() {
	}
	/** Print login form
	 * @return void
	 */
	function loginForm() {
	}
	/** Get login form field
	 * @param string $heading HTML
	 * @param string $value HTML
	 * @param string $name
	 * @return string
	 */
	function loginFormField($name, $heading, $value) {
	}
	/** Authorize the user
	 * @param string $login
	 * @param string $password
	 * @return mixed true for success, string for error message, false for unknown error
	 */
	function login($login, $password) {
	}
	/** Table caption used in navigation and headings
	 * @param TableStatus $tableStatus
	 * @return string HTML code, "" to ignore table
	 */
	function tableName(array $tableStatus) {
	}
	/** Field caption used in select and edit
	 * @param Field|RoutineField $field
	 * @param int $order order of column in select
	 * @return string HTML code, "" to ignore field
	 */
	function fieldName(array $field, $order = 0) {
	}
	/** Get comment of a schema, table, column or routine
	 * @param 'SCHEMA'|'TABLE'|'COLUMN'|'PROCEDURE'|'FUNCTION' $type
	 * @param ?string $comment null if the driver doesn't return comments
	 * @return string HTML code
	 */
	function commentValue($type, $comment) {
	}
	/** Get input for editing a comment
	 * @param 'SCHEMA'|'TABLE'|'COLUMN' $type
	 * @param string $attrs attributes to use inside the tag
	 * @param ?string $comment null if the driver doesn't return comments
	 * @return string HTML code
	 */
	function commentInput($type, $attrs, $comment) {
	}
	/** Print links after select heading
	 * @param TableStatus $tableStatus
	 * @param ?string $set new item options, NULL for no new item
	 * @return void
	 */
	function selectLinks(array $tableStatus, $set = "") {
	}
	/** Get foreign keys for table
	 * @param string $table
	 * @return ForeignKey[] same format as foreign_keys()
	 */
	function foreignKeys($table) {
	}
	/** Find backward keys for table
	 * @param string $table
	 * @param string $tableName
	 * @return BackwardKey[]
	 */
	function backwardKeys($table, $tableName) {
	}
	/** Print backward keys for row
	 * @param BackwardKey[] $backwardKeys
	 * @param string[] $row
	 * @return void
	 */
	function backwardKeysPrint(array $backwardKeys, array $row) {
	}
	/** Query printed in select before execution
	 * @param string $query query to be executed
	 * @param float $start start time of the query
	 * @param bool $failed
	 * @return string
	 */
	function selectQuery($query, $start, $failed = false) {
	}
	/** Query printed in SQL command before execution
	 * @param string $query query to be executed
	 * @return string escaped query to be printed
	 */
	function sqlCommandQuery($query) {
	}
	/** Print HTML code just before the Execute button in SQL command
	 * @return void
	 */
	function sqlPrintAfter() {
	}
	/** Get the maximum length of a URL with the query from SQL command, 0 to never put the query to the URL
	 * @return int
	 */
	function sqlUrlLength() {
	}
	/** Get EXPLAIN of a SELECT in SQL command
	 * @param string[] $orgtables table => orgtable from the result of $query
	 * @param Db $connection
	 * @return string HTML
	 */
	function explain(\Adminer\Db $connection, $query, array $orgtables) {
	}
	/** Description of a row in a table
	 * @param string $table
	 * @return string SQL expression, empty string for no description
	 */
	function rowDescription($table) {
	}
	/** Get descriptions of selected data
	 * @param list<array<?string>> $rows all data to print
	 * @param list<ForeignKey>[] $foreignKeys
	 * @return list<array<?string>>
	 */
	function rowDescriptions(array $rows, array $foreignKeys) {
	}
	/** Get a link to use in select table
	 * @param string $val raw value of the field
	 * @param array{type: string} $field
	 * @return string|void null to create the default link
	 */
	function selectLink($val, array $field) {
	}
	/** Value printed in select table
	 * @param ?string $val HTML-escaped value to print
	 * @param ?string $link link to foreign key
	 * @param array{type: string, full_type?: string} $field
	 * @param string $original original value before applying editVal() and escaping
	 * @return string
	 */
	function selectVal($val, $link, array $field, $original) {
	}
	/** Value conversion used in select and edit
	 * @param array{type: string} $field
	 * @param string|null $val
	 * @return string|null
	 */
	function editVal($val, array $field) {
	}
	/** Get configuration options for AdminerConfig
	 * @return string[] key is config description, value is HTML
	 */
	function config() {
	}
	/** Print table structure in tabular format
	 * @param Field[] $fields
	 * @param TableStatus $tableStatus
	 * @return void
	 */
	function tableStructurePrint(array $fields, array $tableStatus = null) {
	}
	/** Print list of indexes on table in tabular format
	 * @param Index[] $indexes
	 * @param TableStatus $tableStatus
	 * @return void
	 */
	function tableIndexesPrint(array $indexes, array $tableStatus) {
	}
	/** Get the pattern for the name of a new object, empty string lets the database choose it
	 * @param 'PRIMARY'|'UNIQUE'|'INDEX'|'FULLTEXT'|'SPATIAL'|'VECTOR'|'FOREIGN'|'CHECK'|'TRIGGER' $type
	 * @return string {table}, {columns} joined by _ (UPDATE OF prefixed by _ in TRIGGER, none in CHECK), {timing} and {event} as first letters (e.g. biu) and {type} as row or statement in TRIGGER
	 */
	function namePattern($type) {
	}
	/** Get HTML for choosing a column in the Select, Search and Sort boxes of select
	 * @param string[] $columns selectable columns
	 * @param string $attrs
	 * @param string|null $value
	 * @param string $placeholder
	 * @return string
	 */
	function selectColumnInput($attrs, array $columns, $value = "", $placeholder = "") {
	}
	/** Print columns box in select
	 * @param list<string> $select result of selectColumnsProcess()[0]
	 * @param string[] $columns selectable columns
	 * @return void
	 */
	function selectColumnsPrint(array $select, array $columns) {
	}
	/** Print search box in select
	 * @param list<string> $where result of selectSearchProcess()
	 * @param string[] $columns selectable columns
	 * @param Index[] $indexes
	 * @param ?TableStatus $tableStatus
	 * @return void
	 */
	function selectSearchPrint(array $where, array $columns, array $indexes, array $tableStatus = null) {
	}
	/** Print order box in select
	 * @param list<string> $order result of selectOrderProcess()
	 * @param string[] $columns selectable columns
	 * @param Index[] $indexes
	 * @return void
	 */
	function selectOrderPrint(array $order, array $columns, array $indexes) {
	}
	/** Print limit box in select
	 * @param int $limit
	 * @return void
	 */
	function selectLimitPrint($limit) {
	}
	/** Print text length box in select
	 * @param numeric-string $text_length result of selectLengthProcess()
	 * @return void
	 */
	function selectLengthPrint($text_length) {
	}
	/** Print action box in select
	 * @param Index[] $indexes
	 * @return void
	 */
	function selectActionPrint(array $indexes) {
	}
	/** Print command box in select
	 * @return bool whether to print default commands
	 */
	function selectCommandPrint() {
	}
	/** Print import box in select
	 * @return bool whether to print default import
	 */
	function selectImportPrint() {
	}
	/** Print extra text in the end of a select form
	 * @param string[] $emailFields fields holding e-mails
	 * @param string[] $columns selectable columns
	 * @return void
	 */
	function selectEmailPrint(array $emailFields, array $columns) {
	}
	/** Process columns box in select
	 * @param string[] $columns selectable columns
	 * @param Index[] $indexes
	 * @return list<list<string>> [[select_expressions], [group_expressions]]
	 */
	function selectColumnsProcess(array $columns, array $indexes) {
	}
	/** Process search box in select
	 * @param Field[] $fields
	 * @param Index[] $indexes
	 * @param ?TableStatus $tableStatus
	 * @return list<string> expressions to join by AND
	 */
	function selectSearchProcess(array $fields, array $indexes, array $tableStatus = null) {
	}
	/** Create SQL condition from one row of the search box in select
	 * @param string $column SQL expression, e.g. the escaped column passed through Driver::convertSearch()
	 * @param string $op one of operators()
	 * @param string $val
	 * @return string
	 */
	function selectSearchCondition($column, $op, $val) {
	}
	/** Process order box in select
	 * @param Field[] $fields
	 * @param Index[] $indexes
	 * @return list<string> expressions to join by comma
	 */
	function selectOrderProcess(array $fields, array $indexes) {
	}
	/** Process limit box in select
	 * @return int
	 */
	function selectLimitProcess() {
	}
	/** Process length box in select
	 * @return numeric-string number of characters to shorten texts, will be escaped, empty string means unlimited
	 */
	function selectLengthProcess() {
	}
	/** Process extras in select form
	 * @param string[] $where AND conditions
	 * @param list<ForeignKey>[] $foreignKeys
	 * @return bool true if processed, false to process other parts of form
	 */
	function selectEmailProcess(array $where, array $foreignKeys) {
	}
	/** Build SQL query used in select
	 * @param list<string> $select result of selectColumnsProcess()[0]
	 * @param list<string> $where result of selectSearchProcess()
	 * @param list<string> $group result of selectColumnsProcess()[1]
	 * @param list<string> $order result of selectOrderProcess()
	 * @param int $limit result of selectLimitProcess()
	 * @param int $page index of page starting at zero
	 * @return string empty string to use default query
	 */
	function selectQueryBuild(array $select, array $where, array $group, array $order, $limit, $page) {
	}
	/** Query printed after execution in the message
	 * @param string $query executed query
	 * @param string $time elapsed time
	 * @param bool $failed
	 * @return string
	 */
	function messageQuery($query, $time, $failed = false) {
	}
	/** Get HTML of the last error message; the raw message is in connection()->error
	 * @return string
	 */
	function error() {
	}
	/** Print before edit form
	 * @param Field[] $fields
	 * @param mixed $row
	 * @param string $query query which got the row
	 * @param string $time output of format_time()
	 * @param string $table
	 * @param bool|null $update
	 * @return void
	 */
	function editRowPrint($table, array $fields, $row, $update, $query = '', $time = '') {
	}
	/** Functions displayed in edit form
	 * @param Field|array{null:bool} $field
	 * @return string[]
	 */
	function editFunctions(array $field) {
	}
	/** Get options to display edit field
	 * @param ?string $table null in call.inc.php
	 * @param Field $field
	 * @param string $attrs attributes to use inside the tag
	 * @param string|string[]|false|null $value false means original value
	 * @return string custom input field or empty string for default
	 */
	function editInput($table, array $field, $attrs, $value) {
	}
	/** Get hint for edit field
	 * @param ?string $table null in call.inc.php
	 * @param Field $field
	 * @param string|null $value
	 * @return string
	 */
	function editHint($table, array $field, $value) {
	}
	/** Process sent input
	 * @param Field $field
	 * @param string $value
	 * @param string|null $function
	 * @return string expression to use in a query
	 */
	function processInput(array $field, $value, $function = "") {
	}
	/** Return export output options
	 * @return string[]
	 */
	function dumpOutput() {
	}
	/** Return export format options
	 * @return string[] empty to disable export
	 */
	function dumpFormat() {
	}
	/** Print HTML code in the export form
	 * @return void prints data
	 */
	function dumpPrint() {
	}
	/** Export database structure
	 * @param string $db
	 * @return void prints data
	 */
	function dumpDatabase($db) {
	}
	/** Export table structure
	 * @param int $is_view 0 table, 1 view, 2 temporary view table
	 * @param string $table
	 * @param string $style
	 * @return void prints data
	 */
	function dumpTable($table, $style, $is_view = 0) {
	}
	/** Export table data
	 * @param string $query empty to select the rows by Driver::select() from the parts below
	 * @param list<string> $select
	 * @param list<string> $where
	 * @param list<string> $group
	 * @param list<string> $order
	 * @param string $table
	 * @param string $style
	 * @return void prints data
	 */
	function dumpData($table, $style, $query, array $select = array(), array $where = array(), array $group = array(), array $order = array()): void {
	}
	/** Set export filename
	 * @param string $identifier
	 * @return string filename without extension
	 */
	function dumpFilename($identifier) {
	}
	/** Send headers for export
	 * @param string $identifier
	 * @param bool $multi_table
	 * @return string extension
	 */
	function dumpHeaders($identifier, $multi_table = false) {
	}
	/** Print text after export
	 * @return void prints data
	 */
	function dumpFooter() {
	}
	/** Set the path of the file for webserver load
	 * @return string path of the sql dump file
	 */
	function importServerPath() {
	}
	/** Print fieldsets with other import formats
	 * @return void prints data
	 */
	function importPrint() {
	}
	/** Import data sent to the import form and print the result
	 * @return bool whether the data was imported, false to import them as SQL commands
	 */
	function importProcess() {
	}
	/** Print homepage
	 * @return bool whether to print default homepage
	 */
	function homepage() {
	}
	/** Print navigation after Adminer title
	 * @param string $missing can be "auth" if there is no database connection, "db" if there is no database selected, "ns" with invalid schema
	 * @return void
	 */
	function navigation($missing) {
	}
	/** Set up syntax highlight for code and <textarea>
	 * @param TableStatus[] $tables
	 * @return void
	 */
	function syntaxHighlighting(array $tables) {
	}
	/** Print databases list in menu
	 * @param string $missing
	 * @return void
	 */
	function databasesPrint($missing) {
	}
	/** Print table list in menu
	 * @param string[] $actions
	 * @param string $missing
	 * @return string[]
	 */
	function menuActions(array $actions, $missing) {
	}
	/** Print table list in menu
	 * @param TableStatus[] $tables
	 * @return void
	 */
	function tablesPrint(array $tables) {
	}
	/** Get server variables
	 * @return list<string[]> [[$name, $value]]
	 */
	function showVariables() {
	}
	/** Get status variables
	 * @return list<string[]> [[$name, $value]]
	 */
	function showStatus() {
	}
	/** Get process list
	 * @return list<string[]> [$row]
	 */
	function processList() {
	}
	/** Kill a process
	 * @param numeric-string $id
	 * @return Result|bool
	 */
	function killProcess($id) {
	}
	/** Format a size in bytes of tables, indexes and databases
	 * @param float|numeric-string $val
	 * @return string HTML code
	 */
	function formatSizeValue($val) {
	}
}
