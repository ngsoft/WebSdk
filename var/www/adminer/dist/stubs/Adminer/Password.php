<?php
/** @noinspection ALL */

namespace Adminer;

/** Require a password verified by Adminer
* Instantiate it in adminer-plugins.php, it must not extend Plugin - Plugins would ask to configure it.
*/
class Password {

	/** @param string $password_hash result of password_hash() */
	function __construct($password_hash) {
	}
	/** Get plain text description printed in the list of plugins
	 * @return string
	 */
	function description() {
	}
	/** @return array{string, string, string} */
	function credentials() {
	}
	/** @return bool|void
	 * @param string $login
	 * @param string $password
	 */
	function login($login, $password) {
	}
	/** Check if the password is the one allowed by this class
	 * @param string|false|null $password result of get_password()
	 * @return bool
	 */
	protected function passwordMatches($password) {
	}
}
