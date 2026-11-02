<?php
/** @noinspection ALL */

namespace Adminer;

/** Get characters used in compressed string
 * @return string
 */
function compress_alphabet() {
}
// used in compiled version
/**
 * @param string $string
 * @param string $dictionary
 * @return string
 */
function decompress_string($string, $dictionary = "") {
}
/** Decompress a raw deflate stream (RFC 1951)
 * @param string $binary
 * @param string $dictionary
 * @return string
 */
function inflate($binary, $dictionary = "") {
}
/** Read the given number of bits, least significant first, and advance the bit position
 * @param string $binary
 * @param int $pos
 * @param int $count
 * @return int
 */
function inflate_bits($binary, &$pos, $count) {
}
/** Create a canonical Huffman decoding table
* @param int[] $lengths code lengths indexed by symbol
* @return int[][] symbols indexed by code length and code
*/
function inflate_table(array $lengths) {
}
/** Read one Huffman-coded symbol and advance the bit position
* @param int[][] $table
* @param string $binary
* @param int $pos
* @return int
*/
function inflate_symbol($binary, &$pos, array $table) {
}
