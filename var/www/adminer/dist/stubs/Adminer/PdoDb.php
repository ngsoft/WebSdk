<?php
/** @noinspection ALL */

namespace Adminer;

abstract class PdoDb extends \Adminer\SqlDb {

	/**
	 * @var PDO
	 */
	protected $pdo;
	/** Connect to server using DSN
	 * @param mixed[] $options
	 * @param class-string<\PDO> $class
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 * @return string error message
	 */
	function dsn($dsn, $username, $password, array $options = array(), string $class = 'PDO'): string {
	}
	/**
	 * @param string $string
	 * @return string
	 */
	function quote($string) {
	}
	/**
	 * @param string $query
	 * @param bool $unbuffered
	 */
	function query($query, $unbuffered = false) {
	}
	function store_result($result = null) {
	}
	/**
	 * @return bool
	 */
	function next_result() {
	}
	/**
	 * @return bool
	 */
	function inTransaction() {
	}
	/**
	 * @return bool
	 */
	function begin() {
	}
	/**
	 * @return bool
	 */
	function commit() {
	}
	/**
	 * @return bool
	 */
	function rollback() {
	}
}
