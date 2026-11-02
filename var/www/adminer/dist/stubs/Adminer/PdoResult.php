<?php
/** @noinspection ALL */

namespace Adminer;

class PdoResult extends \PDOStatement {

	public $_offset = 0, $num_rows;
	function fetch_assoc() {
	}
	function fetch_row() {
	}
	/**
	 * @return stdClass
	 */
	function fetch_field() {
	}
	function seek($offset) {
	}
}
