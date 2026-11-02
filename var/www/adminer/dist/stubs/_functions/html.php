<?php
/** @noinspection ALL */

namespace Adminer;

/** Return <script> element
 * @param string $source
 * @param string $trailing
 * @return string
 */
function script($source, $trailing = "\n") {
}
/** Return <script src> element
 * @param string $url
 * @param bool $defer
 * @return string
 */
function script_src($url, $defer = false) {
}
/** Get a nonce="" attribute with CSP nonce
 * @return string
 */
function nonce() {
}
/** Get an attribute registering a JS event handler
* @param string $event event name without "on"
* @param string $handler name of a JavaScript function defined by Adminer or by a plugin
* @param mixed $arg argument passed to the handler before the event object
* @return string HTML attribute including the leading space
*/
function on($event, $handler, $arg = null) {
}
/** Get <input type="hidden">
* @param string|int $value
* @param string $name
* @return string HTML
*/
function input_hidden($name, $value = "") {
}
/** Get CSRF <input type="hidden" name="token">
* @return string HTML
*/
function input_token() {
}
/** Get a target="_blank" attribute
 * @return string
 */
function target_blank() {
}
/** Escape for HTML
 * @param string|null $string
 * @return string
 */
function h($string) {
}
/** Convert \n to <br>
 * @param string $string
 * @return string
 */
function nl_br($string) {
}
/** Generate HTML checkbox
* @param string|int $value
* @param string $attrs additional attributes, e.g. an event handler from on()
* @param string $class class of the label, of the input if there's no label
* @param string $name
* @param bool|null $checked
* @param string $label
* @param string $labelled_by
* @return string
*/
function checkbox($name, $value, $checked, $label = "", $attrs = "", $class = "", $labelled_by = "") {
}
/** Generate list of HTML options
* @param string[]|string[][] $options array of strings or arrays (creates optgroup)
* @param mixed $selected
* @param bool $use_keys always use array keys for value="", otherwise only string keys are used
* @return string
*/
function optionlist($options, $selected = null, $use_keys = false) {
}
/** Move system databases or schemas to an optgroup
* @param list<string> $names
* @param bool $schemas
* @return array<string|list<string>>
*/
function group_system(array $names, $schemas = false) {
}
/** Generate HTML <select>
* @param string[]|string[][] $options
* @param string $name
* @param string|null $value
* @param string $attrs
* @param string $labelled_by
* @return string
*/
function html_select($name, array $options, $value = "", $attrs = "", $labelled_by = "") {
}
/** Generate HTML radio list
* @param string[] $options
* @param string $name
* @param string|null $value
* @param string $separator
* @return string
*/
function html_radios($name, array $options, $value = "", $separator = "") {
}
/** Get an attribute asking for confirmation before submit
 * @param string $message
 * @return string
 */
function confirm($message = "") {
}
/** Print header for hidden fieldset (close by </div></fieldset>)
* @param bool $visible
* @param string $id
* @param string $legend
* @return void
*/
function print_fieldset($id, $legend, $visible = false) {
}
/** Return class='active' if $bold is true
 * @param bool $bold
 * @param string $class
 * @return string
 */
function bold($bold, $class = "") {
}
/** Escape string for JavaScript apostrophes
 * @param string $string
 * @return string
 */
function js_escape($string) {
}
/** Escape string to use inside a JavaScript regular expression literal
* @param string $string
* @return string
*/
function js_escape_re($string) {
}
/** Get URL of a page in select
* @param int $page 0-based page number
* @uses $_GET["next"] cursor of the following page in drivers with support("cursor")
* @return string
*/
function pagination_href($page) {
}
/** Generate page number for pagination
 * @param int $page
 * @param int|null $current
 * @return string
 */
function pagination($page, $current) {
}
/** Print hidden fields
* @param mixed[] $process
* @param list<string> $ignore
*/
function hidden_fields(array $process, array $ignore = array(), string $prefix = ''): bool {
}
/** Print hidden fields for GET forms
 * @return void
 */
function hidden_fields_get() {
}
/** Get an attribute displaying the progress of the file upload
* @param string $upload_progress set to the key which the form must send in a field named by session.upload_progress.name before the file field, "" if the progress is not available
* @return string
*/
function on_upload_progress(&$upload_progress) {
}
/** Get <input type='file'>
* @param string $attrs attributes including the leading space
* @param string $rest HTML printed after the input, dropped together with it if the uploads are disabled
* @return string
*/
function file_input($attrs, $rest = "") {
}
/** Print enum or set input field
* @param 'radio'|'checkbox' $type
* @param Field $field
* @param string|string[]|false|null $value false means original value
* @param string $attrs
* @param string $empty
* @return string
*/
function enum_input($type, $attrs, array $field, $value, $empty = "") {
}
/** Print edit input field
* @param Field|RoutineField $field
* @param mixed $value
* @param string|null $function
* @param bool|null $autofocus
* @param bool|null $update
* @return void
*/
function input(array $field, $value, $function, $autofocus = false, $update = false) {
}
/** Process edit input field
* @param Field|RoutineField $field
* @return mixed false to leave the original value
*/
function process_input(array $field) {
}
/** Print results of search in all tables
* @uses $_GET["where"][0]
* @uses $_POST["tables"]
* @return void
*/
function search_tables() {
}
/** Get attributes to display help on mouse over
* @param string $text SQL command
* @param int $side 0 top, 1 left
* @return string HTML attributes including the leading space
*/
function on_help($text, $side = 0) {
}
/** Get attributes to display help with the hovered value on mouse over
* @param string $regexp regular expression transforming the value, empty to display the value itself
* @param string $replacement can use $& and $1
* @return string HTML attributes including the leading space
*/
function on_help_value($regexp = "", $replacement = "") {
}
/** Print edit data form
* @param Field[] $fields
* @param mixed $row
* @param string $query query which got the row
* @param string $time output of format_time()
* @param string $table
* @param bool|null $update
* @param string $error
* @return void
*/
function edit_form($table, array $fields, $row, $update, $error = '', $query = '', $time = '') {
}
/** Create repeat pattern for preg
 * @param string $pattern
 * @param int $length
 * @return string
 */
function repeat_pattern($pattern, $length) {
}
/** Shorten UTF-8 string
* @param list<string> $patterns regular expressions to highlight in the shortened string
* @param string $string
* @param int $length
* @param string $suffix
* @return string escaped string with appended ...
*/
function shorten_utf8($string, $length = 80, $suffix = "", array $patterns = array()): string {
}
/** Escape HTML and wrap the parts matching any of the regular expressions in <mark>
* @param list<string> $patterns regular expressions without delimiters, e.g. (?i:abc)
* @param ?int $length print only this many bytes, the matches crossing the end are highlighted up to it
* @param string $string
* @return string
*/
function highlight_matches($string, array $patterns, $length = null) {
}
/** Get button with icon
 * @param string $icon
 * @param string $name
 * @param string $html
 * @param string $title
 * @param string $attrs
 * @return string
 */
function icon($icon, $name, $html, $title, $attrs = "") {
}
/** Get link copying the adjacent <code> to clipboard
 * @return string
 */
function copy_icon() {
}
