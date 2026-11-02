<?php
/** @noinspection ALL */

namespace Adminer;

// the overridable methods don't use return type declarations so that plugins can be compatible with PHP 5
abstract class Plugin {

	/** @var array<literal-string, string|list<string>>[] */
	protected $translations = array();
	// key is language code
	/** Get plain text plugin description; empty string means to use the first line of class doc-comment
	 * @return string
	 */
	function description() {
	}
	/** Get URL of plugin screenshot
	 * @return string
	 */
	function screenshot() {
	}
	/** Translate a string from $this->translations; Adminer\lang() doesn't work for single language versions
	 * @param literal-string $idf
	 * @param float|string $number
	 * @return string
	 */
	protected function lang($idf, $number = null) {
	}
}
