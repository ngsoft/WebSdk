<?php
/** @noinspection ALL */

namespace Adminer;

/** Print HTML header
* @param string $title used in title, breadcrumb and heading, should be HTML escaped
* @param mixed $breadcrumb ["key" => "link", "key2" => ["link", "desc"]], "#section" of the database page, null for nothing, false for driver only, true for driver and server
* @param string $title2 used after colon in title and heading, should be HTML escaped
* @param bool|string $not_found the object in the URL doesn't exist - print only the error and finish the page, a string is passed to page_footer()
* @param string $doc HTML code of doc_link()
* @param string $error
*/
function page_header($title, $error = "", $breadcrumb = array(), string $title2 = "", $not_found = false, string $doc = ""): void {
}
/** Print the script maintaining the service worker caching the static files
 * @return void
 */
function service_worker() {
}
/** Check whether any connection is logged in
 * @return bool
 */
function has_passwords() {
}
/** Send HTTP headers
 * @return void
 */
function page_headers() {
}
/** Get Content Security Policy headers
* @return list<string[]> of arrays with directive name in key, allowed sources in value
*/
function csp() {
}
/** Get names and checksums of the used designs
* @return array<string, string[]> filename in key, [design name, hex crc32] in value, name is empty for designs without the marker
*/
function design_checksums() {
}
/** Get checksums of official designs shipped with this Adminer version
* @return string[] design name with filename in key, hex crc32 in value
*/
function official_design_checksums() {
}
/** Get HTML displaying a new version even without JavaScript
* @return string noscript iframe or empty string
*/
function version_iframe() {
}
/** Get a CSP nonce
* @return string Base64 value
*/
function get_nonce() {
}
/** Print flash and error messages
 * @param string $error
 * @return void
 */
function page_messages($error) {
}
/** Print HTML footer
* @param ''|'auth'|'db'|'ns' $missing
* @return void
*/
function page_footer($missing = "") {
}
