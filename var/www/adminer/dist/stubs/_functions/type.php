<?php
/** @noinspection ALL */

namespace Adminer;

/** Get values of AS ENUM (...)
* @param string $definition
* @return ?list<string> SQL literals, null if the definition is not an enum
*/
function enum_values($definition) {
}
/** Get queries adding values to an enum type
* @param string $type
* @param string $old
* @param string $new
* @return ?list<string> null if the definitions differ by anything else than added values
*/
function add_enum_values($type, $old, $new) {
}
