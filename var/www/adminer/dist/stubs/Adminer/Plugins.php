<?php
/** @noinspection ALL */

namespace Adminer;

class Plugins {

	/** @var list<object> @visibility protected(set) */
	public $plugins;
	/** @var string[] @visibility protected(set) */
	public $drivers = array();
	// [id => name] of drivers registered by plugins
	/** @var string[] @visibility protected(set) */
	public $driverFiles = array();
	// [id => filename] of files which registered a driver
	/** @visibility protected(set)
	 * @var string
	 */
	public $error = '';
	/** Register plugins
	 * @param ?mixed[] $plugins object instances or null to autoload plugins from adminer-plugins/, non-objects are reported and skipped
	 */
	function __construct($plugins) {
	}
	/** Separate function to not overwrite local variables
	 * @param string $filename
	 * @return mixed whatever the included file returns, 1 if it doesn't return anything
	 */
	function includeOnce($filename) {
	}
	/** Get checksum of a plugin or design file, ignoring line ends and translations
	 * @param string $filename
	 * @return string hex crc32
	 */
	static function checksum($filename) {
	}
	/** Get checksums of files with loaded plugins
	 * @return string[] plugin name in key, hex crc32 in value
	 */
	function checksums() {
	}
	/** Get checksums of official plugins shipped with this Adminer version
	 * @return string[] plugin name in key, hex crc32
	 */
	static function officialChecksums() {
	}
	/**
	 * @param literal-string $name
	 * @param mixed[] $params
	 * @return mixed
	 */
	function __call($name, array $params) {
	}
}
