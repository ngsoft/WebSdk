<?php
/** @noinspection ALL */

namespace Adminer;

// This file is used both in Adminer and Adminer Editor.
/** Get database connection
* @param ?Db $connection2 custom connection to use instead of the default
* @return Db
*/
function connection(\Adminer\Db $connection2 = null) {
}
/** Get Adminer object
* @return Adminer|Plugins
*/
function adminer() {
}
/** Get Driver object
 * @return Driver
 */
function driver() {
}
/** Connect to the database
 * @return Db|null
 */
function connect() {
}
/** Unescape database identifier
* @param string $idf text inside ``
* @return string
*/
function idf_unescape($idf) {
}
/** Shortcut for connection()->quote($string)
 * @param string $string
 * @return string
 */
function q($string) {
}
/** Get a possibly missing item from a possibly missing array
* idx($row, $key) is better than $row[$key] ?? null because PHP will report error for undefined $row
* @param ?mixed[] $array
* @param array-key $key
* @param mixed $default
* @return mixed
*/
function idx($array, $key, $default = null) {
}
/** Remove non-digits from a string; used instead of intval() to not corrupt big numbers
* @param string $val
* @return numeric-string
*/
function number($val) {
}
/** Get regular expression to match integer types
 * @return string
 */
function int_type() {
}
/** Get regular expression to match numeric types
 * @return string
 */
function number_type() {
}
/** Get regular expression to match text types
 * @return string
 */
function text_type() {
}
/** Check whether the type is a user type, e.g. an enum in PostgreSQL
 * @param string $type
 * @return bool
 */
function is_user_type($type) {
}
/** Get full type for SQL with a quoted user type
* @param Field $field
* @return string
*/
function full_type_sql(array $field) {
}
/** Check whether it makes sense to search the field for the value when searching in all columns
* @param Field $field
* @param array{op: string, val: string} $val
* @return bool
*/
function is_searchable(array $field, array $val) {
}
/** Disable magic_quotes_gpc
* @param mixed[] $values
* @param bool $filter whether to leave values as is
* @return mixed[]
*/
function remove_slashes(array $values, $filter = false) {
}
/** Escape or unescape string to use inside form []
 * @param string $idf
 * @param bool $back
 * @return string
 */
function bracket_escape($idf, $back = false) {
}
/** Escape string to use in a query string
 * @param string|null $string
 * @return string
 */
function url_escape($string) {
}
/** Check if connection has at least the given version
* @param string|float $version required version
* @param string|float $maria_db required MariaDB version
* @param Db|null $connection2
* @return bool
*/
function min_version($version, $maria_db = "", \Adminer\Db $connection2 = null) {
}
/** Get connection charset
 * @param Db $connection
 * @return string
 */
function charset(\Adminer\Db $connection) {
}
/** Set PHP ini value if ini_set() is not disabled
* @param string|int|float|bool|null $value
* @param string $option
* @return string|false false on failure
*/
function ini_set($option, $value) {
}
/** Get INI boolean value
 * @param string $ini
 * @return bool
 */
function ini_bool($ini) {
}
/** Get INI bytes value
 * @param string $ini
 * @return int
 */
function ini_bytes($ini) {
}
/** Get the maximum number of rows that a form can send
* @param int $row number of inputs in one row
* @param int $other number of the other inputs
* @return int 0 if the number of fields is not limited
*/
function max_input_vars($row, $other) {
}
/** Get an error message about exceeding max_input_vars
 * @return string
 */
function max_input_vars_error() {
}
/** Check if SID is necessary
 * @return bool
 */
function sid() {
}
/** Set password to session
 * @param string $vendor
 * @param string|null $server
 * @param string $username
 * @param string|null $password
 * @return void
 */
function set_password($vendor, $server, $username, $password) {
}
/** Get password from session
* @return string|false|null null for missing password, false for expired password
*/
function get_password() {
}
/** Get single value from database
* @param string $query
* @param int $field
* @param Db|null $conn
* @return string|false|null false if error, null if the value is NULL
*/
function get_val($query, $field = 0, \Adminer\Db $conn = null) {
}
/** Get list of values from database
* @param array-key $column
* @param string $query
* @return list<string>
*/
function get_vals($query, $column = 0) {
}
/** Get keys from first column and values from second
* @param string $query
* @param Db|null $connection2
* @param bool $set_keys
* @return string[]
*/
function get_key_vals($query, \Adminer\Db $connection2 = null, $set_keys = true) {
}
/** Get all rows of result
* @param string $query
* @param Db|null $connection2
* @param string $error
* @return list<string[]> of associative arrays
*/
function get_rows($query, \Adminer\Db $connection2 = null, $error = "<p class='error'>") {
}
/** Find unique identifier of a row
* @param string[] $row
* @param Index[] $indexes
* @return string[]|void null if there is no unique identifier
*/
function unique_array($row, array $indexes) {
}
/** Apply a function sent in the URL to a column identifier, ignore an unsupported function
* @param string $column escaped column identifier
* @param Field $field
* @param string|null $fun
* @return string
*/
function where_function($fun, $column, array $field) {
}
/** Create SQL condition from parsed query string
* @param array{where:string[], null:list<string>, fun:string[], col:string[], val:string[]} $where parsed query string
* @param Field[] $fields
*/
function where(array $where, array $fields = array()): string {
}
/** Get names of columns used in the WHERE condition in the URL
* @param Field[] $fields
* @return array<string, bool> keys are column names
* @uses $_GET["where"]
* @uses $_GET["null"]
* @uses $_GET["col"]
*/
function where_columns(array $fields) {
}
/** Create SQL condition from query string
* @param Field[] $fields
* @param string $val
*/
function where_check($val, array $fields = array()): string {
}
/** Create query string where condition from value
* @param int $i condition order
* @param string $column column identifier
* @param string|null $value
* @param string $operator
* @return string
*/
function where_link($i, $column, $value, $operator = "=") {
}
/** Get select clause for convertible fields
* @param mixed[] $columns only keys are used
* @param Field[] $fields
* @param list<string> $select
*/
function convert_fields(array $columns, array $fields, array $select = array()): string {
}
/** Get path for a cookie
 * @return string
 */
function cookie_path() {
}
/** Set cookie valid on current path
* @param int $lifetime number of seconds, 0 for session cookie, 2592000 - 30 days
* @param string $name
* @param string|null $value
* @return void
*/
function cookie($name, $value, $lifetime = 2592000) {
}
/** Get contents from URL
* @param resource $context
* @param string $url
* @return array{0: string, 1: string, 2: list<string>, 3: string} [$contents, $status, $headers, $error]
*/
function get_url($url, $context) {
}
/** Decode JSON like json_decode() but keep the text of the numbers which a float would round
* @param string $json
* @return mixed pass a scalar to json_scalar() and the rest to json_encode_exact()
*/
function json_decode_exact($json) {
}
/** Get a scalar decoded by json_decode_exact(), a number as a string
* @param scalar|null $val
* @return scalar|null
*/
function json_scalar($val) {
}
/** Encode a value decoded by json_decode_exact() with the original text of the numbers
* @param mixed $val
* @param int $flags
* @return string
*/
function json_encode_exact($val, $flags = 0) {
}
/** Get settings stored in a cookie
* @param string $cookie
* @return mixed[]
*/
function get_settings($cookie) {
}
/** Get setting stored in a cookie
* @param mixed $default
* @param string $key
* @param string $cookie
* @return mixed
*/
function get_setting($key, $cookie = "adminer_settings", $default = null) {
}
/** Store settings to a cookie
* @param mixed[] $settings
* @param string $cookie
* @return void
*/
function save_settings(array $settings, $cookie = "adminer_settings") {
}
/** Restart stopped session
 * @return void
 */
function restart_session() {
}
/** Stop session if possible
 * @param bool $force
 * @return void
 */
function stop_session($force = false) {
}
/** Get session variable for current server
* @param string $key
* @return mixed
*/
function &get_session($key) {
}
/** Set session variable for current server
* @param mixed $val
* @param string $key
* @return void
*/
function set_session($key, $val) {
}
/** Get authenticated URL
 * @param string $vendor
 * @param string|null $server
 * @param string $username
 * @param string|null $db
 * @return string
 */
function auth_url($vendor, $server, $username, $db = null) {
}
/** Find whether it is an AJAX request
 * @return bool
 */
function is_ajax() {
}
/** Send Location header and exit
* @param ?string $location null to only set a message
* @param string|null $message
* @return ($location is null ? void : never)
*/
function redirect($location, $message = null) {
}
/** Execute query and redirect if successful
* @param bool $redirect
* @param string $query
* @param string|null $location
* @param string $message
* @param bool $execute
* @param bool $failed
* @param string $time
* @return bool
*/
function query_redirect($query, $location, $message, $redirect = true, $execute = true, $failed = false, $time = "") {
}
/** Remember query to print it by queries_redirect()
* @param string $query end with ';' to use DELIMITER
* @return void
*/
function remember_query($query) {
}
/** Execute and remember query
* @param string $query end with ';' to use DELIMITER
* @return Result|bool
*/
function queries($query) {
}
/** Apply command to all array items
* @param list<string> $tables
* @param callable(string):string $escape
* @param string $query
* @return bool
*/
function apply_queries($query, array $tables, $escape = 'Adminer\table') {
}
/** Redirect by remembered queries
* @param bool $redirect
* @param string|null $location
* @param string $message
* @return bool
*/
function queries_redirect($location, $message, $redirect) {
}
/** Format elapsed time
* @param float $start output of microtime(true)
* @return string HTML code
*/
function format_time($start) {
}
/** Get URI relative to the current directory, REQUEST_URI by default
 * @param string $uri
 * @return string
 */
function relative_uri($uri = '') {
}
/** Remove parameter from query string
 * @param string $param
 * @return string
 */
function remove_from_uri($param = "") {
}
/** Get contents of all files sent in one field
* @param string $name
* @param bool $decompress
* @return int|list<array{string, string}>|null null if the file was not sent at all, int for error, [$filename, $content] pairs otherwise
*/
function get_files($name, $decompress = false) {
}
/** Get file contents from $_FILES
* @param string $key
* @param bool $decompress
* @param string $delimiter
* @return int|string|null null if the file was not sent at all, int for error, string otherwise
*/
function get_file($key, $decompress = false, $delimiter = "") {
}
/** Determine upload error
 * @param int|null $error
 * @return string
 */
function upload_error($error) {
}
/** Check whether the string is in UTF-8
 * @param string|null $val
 * @return bool
 */
function is_utf8($val) {
}
/** Get the number of characters in a UTF-8 string
 * @param string $val
 * @return int
 */
function utf8_length($val) {
}
/** Format decimal number
* @param float|numeric-string $val
* @return string
*/
function format_number($val) {
}
/** Format a numeric value of table status
* @param TableStatus $table_status
* @param string $key
* @return string HTML code
*/
function format_status(array $table_status, $key) {
}
/** Generate friendly URL
 * @param string $val
 * @return string
 */
function friendly_url($val) {
}
/** Get status of a single table and fall back to name on error
* @param string $table
* @param bool $fast
* @return TableStatus one element from table_status()
*/
function table_status1($table, $fast = false) {
}
/** Find out foreign keys for each column
* @param string $table
* @return list<ForeignKey>[] [$col => []]
*/
function column_foreign_keys($table) {
}
/** Compute fields() from $_POST edit data in drivers without a schema
* @return Field[] same as fields()
*/
function fields_from_edit() {
}
/** Send headers for export
* @param string $identifier
* @param bool $multi_table
* @return string extension
*/
function dump_headers($identifier, $multi_table = false) {
}
/** Print CSV row
* @param string[] $row
* @return void
*/
function dump_csv(array $row) {
}
/** Split CSV data to rows and values
* @param string $csv
* @param string $separator
* @return list<list<string>> values as they are in the file, quoted values keep the quotes
*/
function parse_csv($csv, $separator) {
}
/** Get value of a CSV field
 * @param string $val
 * @return string
 */
function csv_value($val) {
}
/** Apply SQL function
* @param string $column escaped column identifier
* @param string|null $function
* @return string
*/
function apply_sql_function($function, $column) {
}
/** Get path of the temporary directory
 * @return string
 */
function get_temp_dir() {
}
/** Open and exclusively lock a file
* @param string $filename
* @return resource|void null for error
*/
function file_open_lock($filename) {
}
/** Write and unlock a file
* @param resource $fp
* @param string $data
* @return void
*/
function file_write_unlock($fp, $data) {
}
/** Unlock and close a file
* @param resource $fp
* @return void
*/
function file_unlock($fp) {
}
/** Get first element of an array
* @param mixed[] $array
* @return mixed if not found
*/
function first(array $array) {
}
/** Read password from file adminer.key in temporary directory or create one
* @param bool $create
* @return string '' if the file can not be created
*/
function password_file($create) {
}
/** Get a random string
* @return string 32 hexadecimal characters
*/
function rand_string() {
}
/** Format value to use in select
* @param string|string[]|list<string[]> $val
* @param array{type: string, full_type?: string} $field
* @param ?numeric-string $text_length
* @param list<string> $patterns regular expressions to highlight
* @param string $link
* @return string HTML
*/
function select_value($val, $link, array $field, $text_length, array $patterns = array()): string {
}
/** Check whether the field type is blob or equivalent
* @param array{type: string} $field
* @return bool
*/
function is_blob(array $field) {
}
/** Check whether the field is an identity column which the database doesn't allow to update
* @param Field $field
* @return bool
*/
function is_identity_always(array $field) {
}
/** Check whether the string is e-mail address
 * @param string|null $email
 * @return bool
 */
function is_mail($email) {
}
/** Check whether the string is URL address
 * @param string|null $string
 * @return bool
 */
function is_url($string) {
}
/** Check whether the string is an IPv6 address
 * @param string $address
 * @return bool
 */
function is_ipv6($address) {
}
/** Check if field should be shortened
* @param array{type: string} $field
* @return bool
*/
function is_shortable(array $field) {
}
/** Get the host to be used in a URL, an IPv6 address is put in brackets
 * @param string $host
 * @return string
 */
function url_host($host) {
}
/** Fill the missing parts of a server name
* @param array<string, ?string> $parts
* @return Server
*/
function server_parts(array $parts) {
}
/** Split server into scheme, host, port, socket and path
* @param string $server
* @return Server|null null for an invalid server
*/
function parse_server($server) {
}
/** Get query to compute number of found rows
* @param list<string> $where
* @param list<string> $group
* @param string $table
* @param bool $is_group
* @return string
*/
function count_rows($table, array $where, $is_group, array $group) {
}
/** Run query which can be killed by AJAX call after timing out
* @param string $query
* @return string[]
*/
function slow_query($query) {
}
/** Generate BREACH resistant CSRF token
 * @return string
 */
function get_token() {
}
/** Verify if supplied CSRF token is valid
 * @return bool
 */
function verify_token() {
}
