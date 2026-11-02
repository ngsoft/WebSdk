<?php
/** @noinspection ALL */

namespace Adminer;

/** Get the column of a table, the referenced tables are placed right of the tables referencing them
* @param array<string, mixed[]> $referenced target table => referencing tables
* @param int[] $columns table => column, the computed columns are added to it
* @param string $table
* @return int
*/
function schema_column($table, array $referenced, array &$columns) {
}
/** Get type class to use in CSS
* @param string $type
* @return string|void class=''
*/
function type_class($type) {
}
