<?php
/** @noinspection ALL */

namespace Adminer;

// This file is not used in Adminer Editor.
/** Print select result
* @param Result $result
* @param string[] $orgtables
* @param int|numeric-string $limit
* @param-out int $limit the number of printed rows
* @param bool $edit allow modifying the values by Ctrl+click, the caller must print the result inside a form
* @param-out bool $edit whether at least one value can be modified
* @param Db|null $connection2
* @return string[] $orgtables
*/
function print_select_result($result, \Adminer\Db $connection2 = null, array $orgtables = array(), &$limit = 0, &$edit = false): array {
}
/** Print SQL <textarea> tag
* @param string|list<array{string}> $value
* @param string $name
* @param int $rows
* @param int $cols
* @param string $jush
* @return void
*/
function textarea($name, $value, $rows = 10, $cols = 80, $jush = JUSH) {
}
/** Generate HTML <select> or <input> if $options are empty
* @param string[] $options
* @param string $attrs
* @param string|null $value
* @param string $placeholder
* @return string
*/
function select_input($attrs, array $options, $value = "", $placeholder = "") {
}
/** Print one row in JSON object
* @param string $key or "" to close the object
* @param string|int $val
* @param bool $escape
* @return void
*/
function json_row($key, $val = null, $escape = true) {
}
/** Get the collations of all charsets in a single list
* @return list<string>
*/
function flat_collations() {
}
/** Print table columns for type edit
* @param Field $field
* @param list<string> $collations
* @param string[] $foreign_keys
* @param list<string> $extra_types extra types to prepend
* @param string $key
*/
function edit_type($key, array $field, array $collations, array $foreign_keys = array(), array $extra_types = array()): void {
}
/** Get attributes of an option displayed only for some column types
* @param string $type current column type
* @param string $types regular expression matching the column types displaying the option
* @return string HTML attributes including the leading space
*/
function option_types($type, $types) {
}
/** Filter length value including enums
 * @param string|null $length
 * @return string
 */
function process_length($length) {
}
/** Create the list of values of the IN operator in select
* @param string $val
* @return string SQL expression in parentheses
*/
function process_in($val) {
}
/** Create the range of the BETWEEN operator in select
* @param string $val
* @return string SQL expression "min AND max", "NULL AND NULL" matching nothing if $val isn't two values separated by AND
*/
function process_between($val) {
}
/** Create SQL string from field type
* @param FieldType $field
* @param string $collate
* @return string
*/
function process_type(array $field, $collate = "COLLATE") {
}
/** Create SQL string from field
* @param Field $field basic field information
* @param Field $type_field information about field type
* @return list<string> ["field", "type", "NULL", "DEFAULT", "ON UPDATE", "COMMENT", "AUTO_INCREMENT"]
*/
function process_field(array $field, array $type_field) {
}
/** Get default value clause
* @param Field $field
* @return string
*/
function default_value(array $field) {
}
/** Print table interior for fields editing
* @param (Field|RoutineField)[] $fields
* @param list<string> $collations
* @param 'TABLE'|'PROCEDURE' $type
* @param string[] $foreign_keys
*/
function edit_fields(array $fields, array $collations, $type = "TABLE", array $foreign_keys = array()): void {
}
/** Add or remove field
* @param Field[] $fields
* @param-out (Field|array{})[] $fields
* @return bool
*/
function process_fields(array &$fields) {
}
/** Drop old object and create a new one
* @param string $drop drop old object query
* @param string $create create new object query
* @param string $drop_created drop new object query, used if DDL is not transactional
* @param string $test create test object query, used if DDL is not transactional
* @param string $drop_test drop test object query, used if DDL is not transactional
* @param string $location
* @param string $message_drop
* @param string $message_alter
* @param string $message_create
* @param string $old_name
* @param string $new_name
* @return void redirect on success
*/
function drop_create(
	$drop,
	$create,
	$drop_created,
	$test,
	$drop_test,
	$location,
	$message_drop,
	$message_alter,
	$message_create,
	$old_name,
	$new_name
) {
}
/** Generate SQL query for creating trigger
* @param Trigger $row
* @param string $on
* @return string
*/
function create_trigger($on, array $row) {
}
/** Quote string by dollar quoting which doesn't escape anything, e.g. $$string$$
 * @param string $string
 * @return string
 */
function q_dollar($string) {
}
/** Get the SQL keywords preceding the collation of a routine parameter
 * @param string|null $collation
 * @return string
 */
function routine_collate($collation) {
}
/** Generate SQL query for creating routine
* @param 'PROCEDURE'|'FUNCTION' $routine
* @param Routine $row
* @return string
*/
function create_routine($routine, array $row) {
}
/** Remove the definer of the logged user from a CREATE command
 * @param string $query
 * @return string
 */
function remove_definer($query) {
}
/** Get the name of a new object by Adminer::namePattern()
* @param 'PRIMARY'|'UNIQUE'|'INDEX'|'FULLTEXT'|'SPATIAL'|'VECTOR'|'FOREIGN'|'CHECK'|'TRIGGER' $type
* @param list<string> $columns
* @param string $table
* @return string
*/
function object_name($type, $table, array $columns) {
}
/** Format foreign key to use in SQL query
* @param ForeignKey $foreign_key
* @param string $name empty to let the database choose it
* @return string
*/
function format_foreign_key(array $foreign_key, $name = "") {
}
/** Add a file to TAR
* @param TmpFile $tmp_file
* @param string $filename
* @return void prints the output
*/
function tar_file($filename, $tmp_file) {
}
/** Get the version of the database system as used in its documentation URLs
 * @return string
 */
function doc_version() {
}
/** Create link to database documentation
* @param string[] $paths JUSH => $path
* @param string $text HTML code (🕮 is not on Mac)
* @return string HTML code
*/
function doc_link(array $paths, $text = "📖") {
}
/** Compute size of database
* @param string $db
* @return string formatted
*/
function db_size($db) {
}
/** Print SET NAMES if utf8mb4 might be needed
 * @param string $create
 * @return void
 */
function set_utf8mb4($create) {
}
