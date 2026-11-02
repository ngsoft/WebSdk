<?php
/** @noinspection ALL */

namespace Adminer;

// the line of the first error in the <textarea>, counted from 1
/** Get the line of an error in the <textarea>
* @param string $text the whole <textarea>
* @param int $offset the position of $query in $text
* @param int $line the line of the error in $query, 0 for the first line skipping the leading whitespace
* @return int counted from 1
*/
function query_error_line($text, $offset, $query, $line) {
}
