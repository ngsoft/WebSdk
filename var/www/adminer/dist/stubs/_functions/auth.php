<?php
/** @noinspection ALL */

namespace Adminer;

/**
 * @return void
 */
function add_invalid_login() {
}
/** @param string[] $permanent
 * @return void
 */
function check_invalid_login(array &$permanent) {
}
/** Check if the server requires a password, i.e. it doesn't connect without it
 * @return bool
 */
function password_required() {
}
/** Get a link to instructions for protecting Adminer by a password
* @param ?string $password null to generate a random password
* @return string HTML code
*/
function require_password_link($password) {
}
/** Remove credentials from permanent login
* @param string[] $permanent
* @return void
*/
function unset_permanent(array &$permanent) {
}
/** Render an error message and a login form
* @param string $error HTML
* @param string[] $permanent
* @param bool $invalid_login
* @return never
*/
function auth_error($error, array &$permanent, $invalid_login = true) {
}
