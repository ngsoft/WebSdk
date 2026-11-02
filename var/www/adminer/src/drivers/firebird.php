<?php

/**
 * @author Steve Krämer
 */

namespace Adminer;

add_driver('firebird', 'Firebird (alpha)');

if (isset($_GET['firebird']))
{
    define('Adminer\DRIVER', 'firebird');

    if (extension_loaded('pdo_firebird'))
    {
        class Db extends PdoDb
        {
            public $extension = 'PDO_Firebird';

            public function attach(array $server, $username, $password)
            {
                $host   = $server['host'] . ('' != $server['port'] ? '/' . $server['port'] : '');
                // dbname is 'host/port:/path/to/your.fdb', a server without a path is a local file or an alias from databases.conf
                $return = $this->dsn("firebird:charset=UTF8;dbname={$host}" . ('' != $server['path'] ? ':' . $server['path'] : ''), $username, $password);

                if ('' == $return)
                {
                    $this->server_info = get_val("SELECT rdb\$get_context('SYSTEM', 'ENGINE_VERSION') FROM rdb\$database", 0, $this); // ATTR_SERVER_VERSION is a long description
                }
                return $return;
            }

            public function select_db($database)
            {
                return 'domain' == $database;
            }
        }
    }

    class Driver extends SqlDriver
    {
        public static $extensions = ['PDO_Firebird'];
        public static $jush       = 'firebird';

        public static $serverPath = true; // the path to the database file

        public $onActions         = 'NO ACTION|CASCADE|SET NULL|SET DEFAULT';

        public $insertFunctions   = [
            'date'      => 'current_date',
            'timestamp' => 'current_timestamp',
        ];

        public function __construct(Db $connection)
        {
            parent::__construct($connection);
            $fb4         = min_version(4, '', $connection);
            $this->types = [
                lang('Numbers')       => ['smallint' => 5, 'integer' => 10, 'bigint' => 19] + ($fb4 ? ['int128' => 39] : [])
                                                                                            + ['numeric' => ($fb4 ? 38 : 18), 'decimal' => ($fb4 ? 38 : 18), 'float' => 7, 'double precision' => 15] + ($fb4 ? ['decfloat' => 34] : [])
                                                                                            + (min_version(3, '', $connection) ? ['boolean' => 1] : []),
                lang('Date and time') => ['date' => 10, 'time' => 13, 'timestamp' => 24]
                                                                                            + ($fb4 ? ['time with time zone' => 13, 'timestamp with time zone' => 24] : []),
                lang('Strings')       => ['char' => 32767, 'varchar' => 32765, 'text' => 0], // text - BLOB SUB_TYPE TEXT
                lang('Binary')        => ['blob' => 0],
            ];
        }

        public function operators($tableStatus)
        {
            return ['='];
        }

        public function errorLine($query)
        {
            return preg_match('~\bline (\d+), column \d+~', $this->conn->error, $match) ? (int) $match[1] : 0; // Token unknown - line 3, column 11
        }

        /** Get the JUSH module inlined in the released driver by the release script */
        public static function jushModule()
        {
            return <<<'JS'
jush.tr.firebird = { sqlite_apo: /'/, sqlite_quo: /"/, one: /--/, com: /\/\*/, num: jush.num };

jush.autocompleting.sql.push('firebird', 'sqlite_quo'); // sqlite_quo is a quoted identifier

jush.slugs.firebird = name => name.toLowerCase().replace(/_/g, '-'); // the anchors of the functions use dashes

// the whole language reference is a single page, the keys are its anchors
jush.build_links2('firebird', 'https://firebirdsql.org/file/documentation/html/en/refdocs/fblangref50/firebird-50-language-reference.html$key', /(\b)/, /(\b)/gi, {
	'#fblangref50-dml-select': /(SELECT)/,
	'#fblangref50-dml-select-first-skip': /(FIRST|SKIP)/,
	'#fblangref50-dml-select-from': /(FROM)/,
	'#fblangref50-dml-select-joins': /((?:(?:NATURAL|INNER|CROSS|LEFT|RIGHT|FULL|OUTER)\s+)*JOIN|ON|USING)/,
	'#fblangref50-dml-select-where': /(WHERE)/,
	'#fblangref50-dml-select-groupby': /(GROUP\s+BY|HAVING)/,
	'#fblangref50-dml-select-window': /(WINDOW|OVER|PARTITION\s+BY)/,
	'#fblangref50-dml-select-plan': /(PLAN)/,
	'#fblangref50-dml-select-union': /(UNION)/,
	'#fblangref50-dml-select-orderby': /(ORDER\s+BY|ASC(?:ENDING)?|DESC(?:ENDING)?|NULLS)/,
	'#fblangref50-dml-select-rows': /(ROWS)/,
	'#fblangref50-dml-select-offsetfetch': /(OFFSET|FETCH)/,
	'#fblangref50-dml-with-lock': /(WITH\s+LOCK)/, // must be before WITH
	'#fblangref50-dml-select-cte': /(WITH)/,
	'#fblangref50-dml-insert': /(INSERT)/,
	'#fblangref50-dml-insert-returning': /(RETURNING)/,
	'#fblangref50-dml-update-or-insert': /(UPDATE\s+OR\s+INSERT)/, // must be before UPDATE
	'#fblangref50-dml-update': /(UPDATE)/,
	'#fblangref50-dml-delete': /(DELETE)/,
	'#fblangref50-dml-merge': /(MERGE|MATCHED)/,
	'#fblangref50-dml-execblock': /(EXECUTE\s+BLOCK)/,
	'#fblangref50-dml-execproc': /(EXECUTE\s+PROCEDURE)/,
	'#fblangref50-ddl-tbl-create': /(CREATE(?:\s+GLOBAL\s+TEMPORARY)?\s+TABLE)/,
	'#fblangref50-ddl-tbl-alter': /(ALTER\s+TABLE)/,
	'#fblangref50-ddl-tbl-drop': /(DROP\s+TABLE)/,
	'#fblangref50-ddl-idx-create': /(CREATE(?:\s+UNIQUE)?(?:\s+ASC(?:ENDING)?|\s+DESC(?:ENDING)?)?\s+INDEX)/,
	'#fblangref50-ddl-idx-dropidx': /(DROP\s+INDEX)/,
	'#fblangref50-ddl-view-create': /(CREATE\s+VIEW)/,
	'#fblangref50-ddl-view-drop': /(DROP\s+VIEW)/,
	'#fblangref50-ddl-proc-create': /(CREATE\s+PROCEDURE)/,
	'#fblangref50-ddl-proc-drop': /(DROP\s+PROCEDURE)/,
	'#fblangref50-ddl-func-create': /(CREATE\s+FUNCTION)/,
	'#fblangref50-ddl-func-drop': /(DROP\s+FUNCTION)/,
	'#fblangref50-ddl-trgr-create': /(CREATE\s+TRIGGER)/,
	'#fblangref50-ddl-trgr-drop': /(DROP\s+TRIGGER)/,
	'#fblangref50-ddl-sequence-create': /(CREATE\s+(?:SEQUENCE|GENERATOR))/,
	'#fblangref50-ddl-sequence-drop': /(DROP\s+(?:SEQUENCE|GENERATOR))/,
	'#fblangref50-ddl-domn-create': /(CREATE\s+DOMAIN)/,
	'#fblangref50-ddl-db-create': /(CREATE\s+DATABASE)/,
	'#fblangref50-ddl-comment-create': /(COMMENT\s+ON)/,
	'#fblangref50-transacs-settransac': /(SET\s+TRANSACTION)/,
	'#fblangref50-transacs-commit': /(COMMIT)/,
	'#fblangref50-transacs-rollback': /(ROLLBACK)/,
	'#fblangref50-transacs-savepoint': /(SAVEPOINT)/,
	'#fblangref50-security-grant': /(GRANT)/,
	'#fblangref50-security-revoke': /(REVOKE)/,
	'#fblangref50-datatypes-inttypes': /(SMALLINT|INTEGER|INT128|BIGINT|INT)/,
	'#fblangref50-datatypes-floattypes': /(DOUBLE\s+PRECISION|DECFLOAT|FLOAT|REAL)/,
	'#fblangref50-datatypes-fixedtypes': /(NUMERIC|DECIMAL)/,
	'#fblangref50-datatypes-datetime': /(TIMESTAMP|DATE|TIME)/,
	'#fblangref50-datatypes-chartypes': /(CHARACTER\s+VARYING|CHARACTER|VARCHAR|NCHAR|CHAR)/,
	'#fblangref50-datatypes-boolean': /(BOOLEAN)/,
	'#fblangref50-datatypes-bnrytypes': /(BLOB)/,
	'#fblangref50-functions-datetime': /(CURRENT_DATE|CURRENT_TIME(?:STAMP)?|LOCALTIME(?:STAMP)?)/, // these have anchors in another namespace
	'#fblangref50-scalarfuncs-ceil': /(CEILING|CEIL)/,
	'#fblangref50-scalarfuncs-char-length': /(CHARACTER_LENGTH|CHAR_LENGTH)/,
	'#fblangref50-scalarfuncs-firstday': /(FIRST_DAY)/,
	'#fblangref50-scalarfuncs-lastday': /(LAST_DAY)/,
	'#fblangref50-scalarfuncs-$1': /(ABS|ACOSH|ACOS|ASINH|ASIN|ATAN2|ATANH|ATAN|COSH|COS|COT|EXP|FLOOR|LN|LOG10|LOG|MOD|PI|POWER|RAND|ROUND|SIGN|SINH|SIN|SQRT|TANH|TAN|TRUNC|ASCII_CHAR|ASCII_VAL|BIT_LENGTH|BLOB_APPEND|OCTET_LENGTH|LEFT|LOWER|LPAD|OVERLAY|POSITION|REPLACE|REVERSE|RIGHT|RPAD|SUBSTRING|TRIM|UNICODE_CHAR|UNICODE_VAL|UPPER|HASH|DATEADD|DATEDIFF|EXTRACT|BIN_AND|BIN_NOT|BIN_OR|BIN_SHL|BIN_SHR|BIN_XOR|CHAR_TO_UUID|GEN_UUID|UUID_TO_CHAR|GEN_ID|CAST|COALESCE|DECODE|IIF|MAXVALUE|MINVALUE|NULLIF)(?=\s*\(|$)/,
	'#fblangref50-aggfuncs-$1': /(AVG|COUNT|LIST|MAX|MIN|SUM)(?=\s*\(|$)/,
	'': /(AND|OR|NOT|IN|LIKE|CONTAINING|STARTING\s+WITH|SIMILAR\s+TO|BETWEEN|IS|EXISTS|SINGULAR|SOME|ANY|ALL|DISTINCT|CASE|WHEN|THEN|ELSE|END|AS|INTO|VALUES|SET|DEFAULT|PRIMARY\s+KEY|FOREIGN\s+KEY|REFERENCES|UNIQUE|CHECK|CONSTRAINT|COMPUTED\s+BY|COLLATE|GENERATED|IDENTITY|NULL|TRUE|FALSE|UNKNOWN)/,
}); // collisions: CHARACTER VARYING and CHAR_LENGTH with the CHAR type, MAX and MIN with MAXVALUE and MINVALUE
JS;
        }
    }

    function idf_escape($idf)
    {
        return '"' . str_replace('"', '""', $idf) . '"';
    }

    function table($idf)
    {
        return idf_escape($idf);
    }

    function get_databases($flush)
    {
        return ['domain'];
    }

    function limit($query, $where, $limit, $offset = 0, $separator = ' ')
    {
        $return = '';
        $return .= ($limit ? $separator . "FIRST {$limit}" . ($offset ? " SKIP {$offset}" : '') : '');
        $return .= " {$query}{$where}";
        return $return;
    }

    function limit1($table, $query, $where, $separator = "\n")
    {
        return limit($query, $where, 1, 0, $separator);
    }

    function db_collation($db, array $collations) {}

    function logged_user()
    {
        $credentials = adminer()->credentials();
        return $credentials[1];
    }

    function tables_list()
    {
        $return = [];

        foreach (get_vals('SELECT RDB$RELATION_NAME FROM rdb$relations WHERE rdb$system_flag = 0') as $name)
        {
            $return[trim($name)] = 'table';
        }
        ksort($return);
        return $return;
    }

    function count_tables(array $databases)
    {
        return [];
    }

    function table_status($name = '', $fast = false)
    {
        $return = [];
        $data   = ('' != $name ? [$name => 1] : tables_list());

        foreach ($data as $index => $val)
        {
            $index          = trim($index);
            $return[$index] = [
                'Name'   => $index,
                'Engine' => 'standard',
            ];
        }
        return $return;
    }

    function is_view(array $table_status)
    {
        return false;
    }

    function fk_support(array $table_status)
    {
        return true;
    }

    function fields($table)
    {
        $return = [];
        $query  = 'SELECT r.RDB$FIELD_NAME AS field_name,
r.RDB$DESCRIPTION AS field_description,
COALESCE(r.RDB$DEFAULT_SOURCE, f.RDB$DEFAULT_SOURCE) AS field_default_value,
COALESCE(r.RDB$NULL_FLAG, f.RDB$NULL_FLAG) AS field_not_null_constraint,
r.RDB$IDENTITY_TYPE AS field_identity_type,
f.RDB$CHARACTER_LENGTH AS field_length,
f.RDB$FIELD_PRECISION AS field_precision,
f.RDB$FIELD_SCALE AS field_scale,
f.RDB$FIELD_TYPE AS field_type,
f.RDB$FIELD_SUB_TYPE AS field_subtype,
(SELECT 1 FROM RDB$RELATION_CONSTRAINTS c
	JOIN RDB$INDEX_SEGMENTS s ON s.RDB$INDEX_NAME = c.RDB$INDEX_NAME
	WHERE c.RDB$RELATION_NAME = r.RDB$RELATION_NAME AND c.RDB$CONSTRAINT_TYPE = \'PRIMARY KEY\' AND s.RDB$FIELD_NAME = r.RDB$FIELD_NAME
) AS field_primary
FROM RDB$RELATION_FIELDS r
LEFT JOIN RDB$FIELDS f ON r.RDB$FIELD_SOURCE = f.RDB$FIELD_NAME
WHERE r.RDB$RELATION_NAME = ' . q($table) . '
ORDER BY r.RDB$FIELD_POSITION';
        $types  = [
            7  => 'smallint', 8 => 'integer', 9 => 'quad', 10 => 'float', 11 => 'double precision', 12 => 'date', 13 => 'time', 14 => 'char', 16 => 'bigint',
            23 => 'boolean', 24 => 'decfloat', 25 => 'decfloat', 26 => 'int128', 27 => 'double precision', 28 => 'time with time zone', 29 => 'timestamp with time zone',
            35 => 'timestamp', 37 => 'varchar', 40 => 'cstring', 261 => 'blob',
        ]; // RDB$TYPES with RDB$FIELD_NAME = 'RDB$FIELD_TYPE' names them differently, e.g. LONG, INT64, VARYING

        foreach (get_rows($query) as $row)
        {
            $type                             = idx($types, $row['FIELD_TYPE'], 'unknown');
            $length                           = '';

            if (in_array($row['FIELD_TYPE'], [7, 8, 16, 26]) && $row['FIELD_SUBTYPE'])
            {
                $type   = (1 == $row['FIELD_SUBTYPE'] ? 'numeric' : 'decimal');
                $length = $row['FIELD_PRECISION'] . ($row['FIELD_SCALE'] ? ',' . -$row['FIELD_SCALE'] : '');
            } elseif (preg_match('~char~', $type))
            {
                $length = $row['FIELD_LENGTH'];
            } elseif ('decfloat' == $type)
            {
                $length = (24 == $row['FIELD_TYPE'] ? 16 : 34);
            } elseif ('blob' == $type && 1 == $row['FIELD_SUBTYPE'])
            {
                $type = 'text'; // BLOB SUB_TYPE TEXT, alter_table() translates it back
            }
            $default                          = $row['FIELD_DEFAULT_VALUE']; // RDB$DEFAULT_VALUE is compiled BLR, the source is 'DEFAULT expression' of the column or its domain
            $default_sql                      = false;

            if (null !== $default)
            {
                $default = preg_replace('~^\s*DEFAULT\s+~i', '', $default);

                if (preg_match("~^'(?:[^']|'')*'$~s", $default))
                {
                    $default = idf_unescape($default);
                } elseif (preg_match('~^NULL$~i', $default))
                {
                    $default = null;
                } else
                {
                    $default_sql = ! is_numeric($default);
                }
            }
            $return[trim($row['FIELD_NAME'])] = [
                'field'          => trim($row['FIELD_NAME']),
                'full_type'      => ('text' == $type ? 'blob sub_type text' : $type . ('' != $length ? "({$length})" : '')),
                'type'           => $type,
                'length'         => $length,
                'default'        => (
                    null !== $row['FIELD_IDENTITY_TYPE'] // 0 - GENERATED ALWAYS, 1 - GENERATED BY DEFAULT
                    ? 'GENERATED ' . ($row['FIELD_IDENTITY_TYPE'] ? 'BY DEFAULT' : 'ALWAYS') . ' AS IDENTITY'
                    : $default
                ),
                'default_sql'    => (null === $row['FIELD_IDENTITY_TYPE'] && $default_sql),
                'null'           => ! $row['FIELD_NOT_NULL_CONSTRAINT'], // 1 - NOT NULL on the column or its domain
                'auto_increment' => (null !== $row['FIELD_IDENTITY_TYPE']),
                'primary'        => (1 == $row['FIELD_PRIMARY']),
                'privileges'     => ['insert' => 1, 'select' => 1, 'update' => 1, 'where' => 1, 'order' => 1],
                'comment'        => trim($row['FIELD_DESCRIPTION']),
            ];
        }
        return $return;
    }

    function indexes($table, $connection2 = null)
    {
        $return = [];
        // RDB$FOREIGN_KEY - the index of a foreign key is managed by the constraint
        $query  = 'SELECT i.RDB$INDEX_NAME AS index_name, c.RDB$CONSTRAINT_NAME AS constraint_name, c.RDB$CONSTRAINT_TYPE AS constraint_type,
i.RDB$UNIQUE_FLAG AS unique_flag, i.RDB$INDEX_TYPE AS index_type, i.RDB$INDEX_INACTIVE AS inactive,
i.RDB$EXPRESSION_SOURCE AS expression, ' . (min_version(5, '', $connection2) ? 'i.RDB$CONDITION_SOURCE' : 'NULL') . ' AS condition, s.RDB$FIELD_NAME AS field_name
FROM RDB$INDICES i
LEFT JOIN RDB$INDEX_SEGMENTS s ON s.RDB$INDEX_NAME = i.RDB$INDEX_NAME
LEFT JOIN RDB$RELATION_CONSTRAINTS c ON c.RDB$INDEX_NAME = i.RDB$INDEX_NAME
WHERE i.RDB$RELATION_NAME = ' . q($table) . ' AND i.RDB$FOREIGN_KEY IS NULL
ORDER BY c.RDB$CONSTRAINT_TYPE NULLS LAST, i.RDB$UNIQUE_FLAG DESC, i.RDB$INDEX_NAME, s.RDB$FIELD_POSITION';

        foreach (get_rows($query, $connection2) as $row)
        {
            $name                       = trim($row['CONSTRAINT_NAME'] ?: $row['INDEX_NAME']); // the constraint is dropped by its name, the index can be named differently, e.g. RDB$PRIMARY1
            $return[$name]['type']      = ('PRIMARY KEY' == $row['CONSTRAINT_TYPE'] ? 'PRIMARY' : ($row['UNIQUE_FLAG'] ? 'UNIQUE' : 'INDEX'));
            // an expression index has no segments, its source includes the parentheses of COMPUTED BY
            $return[$name]['columns'][] = (null !== $row['EXPRESSION'] ? substr($row['EXPRESSION'], 1, -1) : trim($row['FIELD_NAME']));
            $return[$name]['lengths']   = [];
            $return[$name]['descs'][]   = (1 == $row['INDEX_TYPE'] ? '1' : null); // DESCENDING applies to the whole index
            $return[$name]['partial']   = preg_replace('~^WHERE\s+~i', '', (string) $row['CONDITION']);
            $return[$name]['invalid']   = (1 == $row['INACTIVE']);
        }
        return $return;
    }

    function alter_indexes($table, $alter)
    {
        $drop    = [];
        $queries = [];

        foreach ($alter as $val)
        {
            $name = $val[1];

            if ('DROP' == $val[2])
            {
                $drop[] = (
                    'PRIMARY' == $val[0]
                    || ('UNIQUE' == $val[0] && get_val('SELECT 1 FROM RDB$RELATION_CONSTRAINTS WHERE RDB$RELATION_NAME = ' . q($table) . ' AND RDB$CONSTRAINT_NAME = ' . q($name)))
                    ? 'ALTER TABLE ' . table($table) . ' DROP CONSTRAINT ' . idf_escape($name)
                    : 'DROP INDEX ' . idf_escape($name)
                );
            } else
            {
                // DESCENDING applies to the whole index, mixed directions are left for the server to reject
                $columns    = preg_replace('~ DESC$~', '', $val[2]);
                $desc       = ! array_diff_key($val[2], preg_grep('~ DESC$~', $val[2]));
                $expression = preg_grep('~^"~', $columns, PREG_GREP_INVERT);
                $queries[]  = (
                    'PRIMARY' == $val[0] || ('UNIQUE' == $val[0] && ! $desc && ! $expression && '' == $val[4])
                    ? 'ALTER TABLE ' . table($table) . ' ADD' . ('' != $name ? ' CONSTRAINT ' . idf_escape($name) : '')
                        . ('PRIMARY' == $val[0] ? ' PRIMARY KEY' : ' UNIQUE') . ' (' . implode(', ', $val[2]) . ')'
                    : 'CREATE' . ('UNIQUE' == $val[0] ? ' UNIQUE' : '') . ($desc ? ' DESCENDING' : '')
                        . ' INDEX ' . idf_escape('' != $name ? $name : uniqid($table . '_')) . ' ON ' . table($table)
                        . ($expression ? ' COMPUTED BY' : '') . ' (' . implode(', ', $desc ? $columns : $val[2]) . ')'
                        . ('' != $val[4] ? " WHERE {$val[4]}" : '')
                );
            }
        }

        // drop first, a changed index keeps its name
        foreach (array_merge($drop, $queries) as $query)
        {
            if ( ! queries($query))
            {
                return false;
            }
        }
        return true;
    }

    function auto_increment()
    {
        return '';
    }

    function alter_table($table, $name, array $fields, array $foreign, $comment, $engine, $collation, $auto_increment, $partitioning)
    {
        $alter          = [];
        $queries        = [];
        $orig_fields    = ('' != $table ? fields($table) : []);
        $firebird_field = function (array $val)
        {
            $val[1] = (' text' == $val[1] ? ' blob sub_type text' : $val[1]);
            $val[2] = (' NULL' == $val[2] ? '' : $val[2]); // Firebird doesn't accept NULL in the column definition
            return $val;
        };

        foreach ($fields as $field)
        {
            $column = idf_escape($field[0]);
            $val    = $field[1];

            if ( ! $val)
            {
                $alter[] = "DROP {$column}";
            } else
            {
                $val = $firebird_field($val);

                if (isset($val[6]) && '' == $val[3]) // auto_increment
                {$val[3] = ' GENERATED BY DEFAULT AS IDENTITY';
                }

                if ('' == $field[0])
                {
                    $alter[] = ('' != $table ? 'ADD ' : '  ') . "{$val[0]}{$val[1]}{$val[3]}{$val[2]}"; // DEFAULT before NOT NULL

                    if (isset($val[6]) && '' == $table)
                    {
                        $alter[] = "  PRIMARY KEY ({$val[0]})";
                    }
                } else
                {
                    $orig_field = $orig_fields[$field[0]];
                    $orig       = $firebird_field(process_field($orig_field, $orig_field));

                    if ($val[1] != $orig[1])
                    {
                        $alter[] = "ALTER {$column} TYPE{$val[1]}";
                    }

                    if ($val[3] != $orig[3])
                    {
                        $alter[] = "ALTER {$column} " . ('' != $val[3] ? "SET{$val[3]}" : 'DROP DEFAULT');
                    }

                    if ($val[2] != $orig[2])
                    {
                        $alter[] = "ALTER {$column} " . ('' != $val[2] ? 'SET' : 'DROP') . ' NOT NULL';
                    }

                    if ($column != $val[0])
                    {
                        $queries[] = 'ALTER TABLE ' . table($table) . " ALTER {$column} TO {$val[0]}"; // after the changes referring to the original name
                    }
                }
            }
        }
        $alter          = array_merge($alter, $foreign);

        if ('' == $table)
        {
            return queries('CREATE TABLE ' . table($name) . " (\n" . implode(",\n", $alter) . "\n)");
        }

        if ($table != $name)
        {
            $queries[] = 'ALTER TABLE ' . table($table) . ' RENAME TO ' . table($name); // not supported by Firebird, let it report the error
        }

        if ($alter)
        {
            array_unshift($queries, 'ALTER TABLE ' . table($table) . ' ' . implode(', ', $alter));
        }

        foreach ($queries as $query)
        {
            if ( ! queries($query))
            {
                return false;
            }
        }
        return true;
    }

    function drop_tables(array $tables)
    {
        return apply_queries('DROP TABLE', $tables);
    }

    function foreign_keys($table)
    {
        $return = [];
        $query  = 'SELECT c.RDB$CONSTRAINT_NAME AS name, s.RDB$FIELD_NAME AS source, u.RDB$RELATION_NAME AS target_table, us.RDB$FIELD_NAME AS target,
rc.RDB$DELETE_RULE AS on_delete, rc.RDB$UPDATE_RULE AS on_update
FROM RDB$RELATION_CONSTRAINTS c
JOIN RDB$REF_CONSTRAINTS rc ON rc.RDB$CONSTRAINT_NAME = c.RDB$CONSTRAINT_NAME
JOIN RDB$RELATION_CONSTRAINTS u ON u.RDB$CONSTRAINT_NAME = rc.RDB$CONST_NAME_UQ
JOIN RDB$INDEX_SEGMENTS s ON s.RDB$INDEX_NAME = c.RDB$INDEX_NAME
JOIN RDB$INDEX_SEGMENTS us ON us.RDB$INDEX_NAME = u.RDB$INDEX_NAME AND us.RDB$FIELD_POSITION = s.RDB$FIELD_POSITION
WHERE c.RDB$RELATION_NAME = ' . q($table) . ' AND c.RDB$CONSTRAINT_TYPE = \'FOREIGN KEY\'
ORDER BY c.RDB$CONSTRAINT_NAME, s.RDB$FIELD_POSITION';

        foreach (get_rows($query) as $row)
        {
            $name                       = trim($row['NAME']);
            $return[$name]['table']     = trim($row['TARGET_TABLE']);
            $return[$name]['source'][]  = trim($row['SOURCE']);
            $return[$name]['target'][]  = trim($row['TARGET']);
            // RESTRICT is stored for an action not specified, it behaves as NO ACTION which is the only one of them accepted in SQL
            $return[$name]['on_delete'] = str_replace('RESTRICT', 'NO ACTION', trim($row['ON_DELETE']));
            $return[$name]['on_update'] = str_replace('RESTRICT', 'NO ACTION', trim($row['ON_UPDATE']));
        }
        return $return;
    }

    function collations()
    {
        return [];
    }

    function information_schema($db)
    {
        return false;
    }

    function error()
    {
        return h(connection()->error);
    }

    function last_id($result) {}

    function explain(Db $connection, $query) {}

    function found_rows(array $table_status, array $where) {}

    function types()
    {
        return [];
    }

    function convert_field(array $field) {}

    function unconvert_field(array $field, $return)
    {
        return $return;
    }

    function support($feature)
    {
        return preg_match('~^(columns|descidx|drop_col|indexes|single_db|sql|table)$~', $feature) || ('partial_indexes' == $feature && min_version(5));
    }
}
