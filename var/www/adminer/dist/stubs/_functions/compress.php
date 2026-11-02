<?php
/** @noinspection ALL */

namespace Adminer;

// this file is used only in compilation, decompress_string() is in decompress.inc.php; requires the zlib extension
/** Compress string with deflate to characters from compress_alphabet(), tested by tests/unit/compress.php
 * @param string $string
 * @param string $dictionary
 * @return string
 */
function compress_string($string, $dictionary = "") {
}
