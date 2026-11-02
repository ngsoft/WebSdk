<?php
/** @noinspection ALL */

namespace Adminer;

// this could be interface when "Db extends \mysqli" can have compatible type declarations (PHP 7)
// interfaces can include properties only since PHP 8.4
abstract class SqlDb {

	/** @var ?Db */
	static $instance;
	/** @var bool */
	static $untrusted = false;
	// queries contain a fragment sent by the user, drivers should not allow multiple commands and modifying data in them
	/** @var string */
	public $extension;
	// extension name
	/** @var string */
	public $flavor = '';
	// different vendor with the same API, e.g. MariaDB; usually stays empty
	/** @var string */
	public $server_info;
	// server version
	/** @var int */
	public $affected_rows = 0;
	// number of affected rows
	/** @var string */
	public $info = '';
	// see https://php.net/mysql_info
	/** @var int */
	public $errno = 0;
	// last error code
	/** @var string */
	public $error = '';
	// last error message
	/** @var Result|bool */
	protected $multi;
	// used for multiquery
	/** Connect to server
	 * @param Server $server
	 * @param string $username
	 * @param string $password
	 * @return string error message
	 */
	abstract function attach(array $server, $username, $password);
	/** Quote string to use in SQL
	 * @param string $string
	 * @return string escaped string enclosed in '
	 */
	abstract function quote($string);
	/** Select database
	 * @param string $database
	 * @return bool boolish
	 */
	abstract function select_db($database);
	/** Send query
	 * @param string $query
	 * @param bool $unbuffered
	 * @return Result|bool
	 */
	abstract function query($query, $unbuffered = false);
	/** Send query with more resultsets
	 * @param string $query
	 * @return Result|bool
	 */
	function multi_query($query) {
	}
	/** Get current resultset
	 * @return Result|bool
	 */
	function store_result() {
	}
	/** Fetch next resultset
	 * @return bool
	 */
	function next_result() {
	}
	/** Check if a transaction is in progress, false if the extension can't tell
	 * @return bool
	 */
	function inTransaction() {
	}
	/** Begin transaction, the extensions with a transaction API use it
	 * @return bool
	 */
	function begin() {
	}
	/** Commit transaction
	 * @return bool
	 */
	function commit() {
	}
	/** Rollback transaction, it is called also without a transaction
	 * @return bool
	 */
	function rollback() {
	}
}
