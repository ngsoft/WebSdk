<?php

namespace Adminer;

if ( ! ini_bool('allow_url_fopen'))
{
    return false;
}

add_driver('elastic', 'Elasticsearch');

if (isset($_GET['elastic']))
{
    define('Adminer\DRIVER', 'elastic');

    class Db extends SqlDb
    {
        public $extension = 'JSON';
        private $url;
        /** @var array[] */
        private $cache    = []; // results of cachedQuery()

        /** Perform a request to the server.
         * @param bool       $log     remember the command to print it in the message, use it for the commands modifying data
         * @param mixed      $path
         * @param null|mixed $content
         * @param mixed      $method
         *
         * @return array|false
         */
        public function rootQuery($path, $content = null, $method = 'GET', $log = false)
        {
            if ($log)
            {
                if ( ! Queries::$start)
                {
                    Queries::$start = microtime(true);
                }
                // the same format as in Driver::select(), queries() is not used because it would append the SQL delimiter
                Queries::$queries[] = "{$method} {$path}" . (null !== $content ? ': ' . json_encode($content) : '');
            }
            list($file, $status, , $error) = get_url("{$this->url}/" . ltrim($path, '/'), stream_context_create([
                'ssl'  => $this->sslOptions(),
                'http' => [
                    'method'          => $method,
                    'content'         => null !== $content ? json_encode($content) : null,
                    'header'          => null  !== $content ? 'Content-Type: application/json' : [],
                    'ignore_errors'   => 1,
                    'follow_location' => 0,
                    'max_redirects'   => 0,
                ],
            ]));

            if (false === $file)
            {
                // $error is created by PHP, the response of the server is never printed
                $this->error = ($error ?: lang('Invalid server or credentials.'));
                return false;
            }

            $return                        = json_decode($file, true);

            if (null === $return)
            {
                $this->error = lang('Invalid server or credentials.');
                return false;
            }

            if (2 != $status[0])
            {
                if (isset($return['error']['root_cause'][0]['type']))
                {
                    $this->error = $return['error']['root_cause'][0]['type'] . ': ' . $return['error']['root_cause'][0]['reason'];
                } elseif (isset($return['status'], $return['error']) && is_string($return['error']))
                {
                    $this->error = $return['error'];
                }

                return false;
            }

            return $return;
        }

        /** Perform a GET request and cache its result.
         * @param mixed $path
         *
         * @return array|false
         */
        public function cachedQuery($path)
        {
            // the indexes can be altered only by a request which redirects afterwards
            if ( ! array_key_exists($path, $this->cache))
            {
                $this->cache[$path] = $this->rootQuery($path);
            }
            return $this->cache[$path];
        }

        /** Perform query relative to actual selected DB */
        public function query($query, $unbuffered = false)
        {
            if ('S' == $query[0])
            {
                // support for global search through all tables
                if (preg_match('/SELECT 1 FROM ([^ ]+) WHERE (.+) LIMIT ([0-9]+)/', $query, $matches))
                {
                    $where = explode(' AND ', $matches[2]);
                    return driver()->select($matches[1], ['*'], $where, [], [], $matches[3]);
                }

                // number of rows in select, built by count_rows()
                if (preg_match('~^SELECT COUNT\(\*\) FROM (\S+)( WHERE (.+))?$~s', $query, $matches))
                {
                    $count = driver()->countRows($matches[1], '' != $matches[3] ? explode(' AND ', $matches[3]) : []);
                    return false === $count ? false : new Result([[$count]]);
                }
            }
            return false;
        }

        /** @return string */
        public function attach($server, $username, $password)
        {
            preg_match('~^(https?://)?(.*)~', $server, $match);

            if ( ! strpos($match[2], ':'))
            {
                $match[2] .= ':9200';
            }
            $this->url         = ($match[1] ?: 'http://') . urlencode($username) . ':' . urlencode($password) . "@{$match[2]}";
            $return            = $this->rootQuery('');

            if ( ! $return)
            {
                return $this->error;
            }
            $version           = $return['version'];
            $this->flavor      = ('opensearch' == $version['distribution'] ? 'opensearch' : ''); // Elasticsearch sends no distribution
            $this->server_info = $version['number'];
            return '';
        }

        public function select_db($database)
        {
            return true;
        }

        /** @return string */
        public function quote($string)
        {
            return $string;
        }

        /** Get SSL options for the stream context.
         * @return mixed[]
         */
        private function sslOptions()
        {
            $return = [];
            $ssl    = adminer()->connectSsl();

            if ($ssl)
            {
                if ($ssl['ca'])
                {
                    $return['cafile'] = $ssl['ca'];
                }

                if ($ssl['cert'])
                {
                    $return['local_cert'] = $ssl['cert'];
                }

                if ($ssl['key'])
                {
                    $return['local_pk'] = $ssl['key'];
                }

                if (isset($ssl['verify']))
                {
                    $return['verify_peer']      = $ssl['verify'];
                    $return['verify_peer_name'] = $ssl['verify'];
                }
            }
            return $return;
        }
    }

    class Result
    {
        public $num_rows;
        private $rows;
        private $fields;

        public function __construct($rows)
        {
            $this->num_rows = count($rows);
            $this->rows     = $rows;
            $this->fields   = array_keys(idx($rows, 0, []));
            reset($this->rows);
        }

        public function fetch_assoc()
        {
            $return = current($this->rows);
            next($this->rows);
            return $return;
        }

        public function fetch_row()
        {
            $row = $this->fetch_assoc();
            return $row ? array_values($row) : false;
        }

        /** @return \stdClass */
        public function fetch_field()
        {
            $field = current($this->fields);
            next($this->fields);
            return (object) ['name' => $field, 'type' => 15, 'charsetnr' => 0];
        }
    }

    class Driver extends SqlDriver
    {
        public static $extensions = ['json + allow_url_fopen'];
        public static $jush       = 'elastic';

        public $insertFunctions   = ['json'];
        public $operators         = ['=', 'must', 'should', 'must_not'];

        public function __construct(Db $connection)
        {
            parent::__construct($connection);
            $this->types = [
                lang('Numbers')       => ['long' => 3, 'integer' => 5, 'short' => 8, 'byte' => 10, 'double' => 20, 'float' => 66, 'half_float' => 12, 'scaled_float' => 21, 'boolean' => 1],
                lang('Date and time') => ['date' => 10],
                lang('Strings')       => ['text' => 65535, 'keyword' => 65535],
                lang('Binary')        => ['binary' => 255],
            ];
        }

        /** Get the JUSH module inlined in the released driver by the release script.
         * @return string
         */
        public static function jushModule()
        {
            return ''; // the repository and the source archive load adminer/static/jush/modules/jush-elastic.js
        }

        public static function connect($server, $username, $password)
        {
            if ( ! preg_match('~^(https?://)?[-a-zA-Z\d.]+(:\d+)?$~', $server))
            {
                return lang('Invalid server.');
            }
            $connection = parent::connect($server, $username, $password); // servers accepting any password are refused by Adminer::login()

            if (is_string($connection))
            {
                return $connection;
            }

            if ('opensearch' == $connection->flavor) // we don't use "Elasticsearch / OpenSearch" by default because it's too long
            {add_driver(DRIVER, 'OpenSearch');
            }
            return $connection;
        }

        public function select($table, array $select, array $where, array $group, array $order = [], $limit = 1, $page = 0, $print = false)
        {
            $fields      = fields($table);
            $data        = [];

            if ($select != ['*'])
            {
                $data['_source'] = array_values($select);
            }

            if ($order)
            {
                $sort         = [];

                foreach ($order as $col)
                {
                    $col    = preg_replace('~ DESC$~', '', $col, 1, $count);
                    $col    = idx($fields[$col], 'sort', $col); // text fields are sortable only by their keyword sub-field
                    $sort[] = ($count ? [$col => 'desc'] : $col);
                }
                $data['sort'] = $sort;
            }

            if ($limit)
            {
                $data['size'] = $limit;

                if ($page)
                {
                    $data['from'] = ($page * $limit);
                }
            } else
            {
                $data['size'] = 10000; // 0 - all rows, used by export; 10000 is the default index.max_result_window, getting more would need a scroll
            }

            $bool        = $this->buildQuery($where, $fields);

            if ($bool)
            {
                $data['query'] = $bool;
            }

            $query       = urlencode($table) . '/_search';
            $start       = microtime(true);
            $search      = $this->conn->rootQuery($query, $data ?: null);

            $this->query = "GET {$query}: " . json_encode($data);

            if ($print)
            {
                echo adminer()->selectQuery($this->query, $start, ! $search);
            }

            if (empty($search))
            {
                return false;
            }

            $columns     = ($select == ['*'] ? array_keys($fields) : $select);
            $return      = [];

            foreach ($search['hits']['hits'] as $hit)
            {
                $row      = [];

                foreach ($columns as $key)
                {
                    $val       = ('_id' == $key ? $hit['_id'] : elastic_value($hit['_source'], $key));
                    $row[$key] = (is_bool($val) ? ($val ? 'true' : 'false') : (is_array($val) ? json_encode($val) : $val));
                }
                $return[] = $row;
            }

            return new Result($return);
        }

        /** Get number of rows matching the conditions.
         * @param list<string> $where
         * @param mixed        $table
         *
         * @return false|int
         */
        public function countRows($table, array $where)
        {
            $bool   = $this->buildQuery($where, fields($table));
            $return = $this->conn->rootQuery(urlencode($table) . '/_count', $bool ? ['query' => $bool] : null);
            return false === $return ? false : $return['count'];
        }

        public function update($table, array $set, $queryWhere, $limit = 0, $separator = "\n")
        {
            // ! use $limit
            $parts = preg_split('~ *= *~', $queryWhere);

            if (2 == count($parts))
            {
                $id                        = trim($parts[1]);
                $query                     = "{$table}/_update/{$id}?refresh=true"; // the redirect displays the data so they must be searchable
                $this->conn->affected_rows = 0;
                return $this->conn->rootQuery($query, ['doc' => $this->castRecord($table, $set)], 'POST', true);
            }

            return false;
        }

        public function insert($type, array $record)
        {
            $query               = "{$type}/_doc/";

            if (isset($record['_id']) && 'NULL' != $record['_id'])
            {
                $query .= $record['_id'];
                unset($record['_id']);
            }

            foreach ($record as $key => $value)
            {
                if ('NULL' == $value)
                {
                    unset($record[$key]);
                }
            }
            $response            = $this->conn->rootQuery("{$query}?refresh=true", $this->castRecord($type, $record), 'POST', true); // the redirect displays the data so they must be searchable

            if (false == $response)
            {
                return false;
            }
            $this->conn->last_id = $response['_id'];

            return $response['result'];
        }

        public function delete($table, $queryWhere, $limit = 0)
        {
            // ! use $limit
            $ids                       = [];

            if (idx($_GET['where'], '_id'))
            {
                $ids[] = $_GET['where']['_id'];
            }

            if (isset($_POST['check']))
            {
                foreach ($_POST['check'] as $check)
                {
                    $parts = preg_split('~ *= *~', $check);

                    if (2 == count($parts))
                    {
                        $ids[] = trim($parts[1]);
                    }
                }
            }

            $this->conn->affected_rows = 0;

            foreach ($ids as $id)
            {
                $query    = "{$table}/_doc/{$id}?refresh=true";
                $response = $this->conn->rootQuery($query, null, 'DELETE', true);

                if (isset($response['result']) && 'deleted' == $response['result'])
                {
                    ++$this->conn->affected_rows;
                }
            }

            return (bool) $this->conn->affected_rows;
        }

        /** Build the search query from the conditions.
         * @param list<string> $where
         * @param mixed[]      $fields result of fields()
         *
         * @return mixed[]
         */
        private function buildQuery(array $where, array $fields)
        {
            $return = [];

            foreach ($where as $val)
            {
                if (preg_match('~^\((.+ OR .+)\)$~', $val, $matches))
                {
                    $parts = explode(' OR ', $matches[1]);
                    $terms = [];

                    foreach ($parts as $part)
                    {
                        list($col, $op, $val) = explode(' ', $part, 3);
                        $term                 = [$col => $val];

                        if ('boolean' == idx($fields[$col], 'full_type') && 'true' !== $val && 'false' !== $val)
                        {
                            continue;
                        }

                        if ('=' == $op)
                        {
                            $terms[] = ['term' => $term];
                        } elseif (in_array($op, ['must', 'should', 'must_not']))
                        {
                            $return['bool'][$op][]['match'] = $term;
                        }
                    }

                    if ( ! empty($terms))
                    {
                        $return['bool']['filter'][]['bool']['should'] = $terms;
                    }
                } else
                {
                    list($col, $op, $val) = explode(' ', $val, 3);
                    $term                 = [$col => $val];

                    if ('=' == $op)
                    {
                        $return['bool']['filter'][] = ['term' => $term];
                    } elseif (in_array($op, ['must', 'should', 'must_not']))
                    {
                        $return['bool'][$op][]['match'] = $term;
                    }
                }
            }
            return $return;
        }

        /** Convert the values to the types expected by Elasticsearch.
         * @param string[] $record
         * @param mixed    $table
         *
         * @return mixed[]
         */
        private function castRecord($table, array $record)
        {
            $fields = fields($table);
            $return = [];

            foreach ($record as $key => $val)
            {
                $type   = idx($fields[$key], 'type');

                if ('boolean' == $type)
                {
                    $val = ($val && 'false' !== $val); // the checkbox sends 1 or 0
                } elseif (preg_match('~^(long|integer|short|byte|double|float|half_float|scaled_float)$~', "{$type}") && is_numeric($val) && '' . ($val + 0) === "{$val}")
                {
                    $val += 0; // store the number as a number, unless the conversion would lose precision
                }
                // the columns of object fields are named by their path
                $target = &$return;

                foreach (explode('.', $key) as $part)
                {
                    $target = &$target[$part];
                }
                $target = $val;
                unset($target);
            }
            return $return;
        }
    }

    function support($feature)
    {
        return preg_match('~^(single_db|table|columns)$~', $feature);
    }

    function logged_user()
    {
        $credentials = adminer()->credentials();

        return $credentials[1];
    }

    function get_databases($flush)
    {
        return ['data'];
    }

    function limit($query, $where, $limit, $offset = 0, $separator = ' ')
    {
        return " {$query}{$where}" . ($limit ? $separator . "LIMIT {$limit}" . ($offset ? " OFFSET {$offset}" : '') : '');
    }

    function collations()
    {
        return [];
    }

    function db_collation($db, $collations) {}

    function count_tables($databases)
    {
        $return = connection()->cachedQuery('_aliases');
        return ['data' => ($return ? count($return) : 0)];
    }

    function tables_list()
    {
        $aliases = connection()->cachedQuery('_aliases');

        if (empty($aliases))
        {
            return [];
        }

        ksort($aliases);

        $tables  = [];

        foreach ($aliases as $name => $index)
        {
            $tables[$name] = 'table';

            ksort($index['aliases']);
            $tables += array_fill_keys(array_keys($index['aliases']), 'view');
        }

        return $tables;
    }

    function table_status($name = '', $fast = false)
    {
        $stats   = connection()->cachedQuery('_stats');
        $aliases = connection()->cachedQuery('_aliases');

        if (empty($stats) || empty($aliases))
        {
            return [];
        }

        $result  = [];

        if ('' != $name)
        {
            if (isset($stats['indices'][$name]))
            {
                return [format_index_status($name, $stats['indices'][$name])];
            }

            foreach ($aliases as $index_name => $index)
            {
                foreach ($index['aliases'] as $alias_name => $alias)
                {
                    if ($alias_name == $name)
                    {
                        return [format_alias_status($alias_name, $stats['indices'][$index_name])];
                    }
                }
            }

            return [];
        }

        ksort($stats['indices']);

        foreach ($stats['indices'] as $name => $index)
        {
            if ('.' == $name[0])
            {
                continue;
            }

            $result[$name] = format_index_status($name, $index);

            if ( ! empty($aliases[$name]['aliases']))
            {
                ksort($aliases[$name]['aliases']);

                foreach ($aliases[$name]['aliases'] as $alias_name => $alias)
                {
                    $result[$alias_name] = format_alias_status($alias_name, $stats['indices'][$name]);
                }
            }
        }

        return $result;
    }

    function format_index_status($name, $index)
    {
        return [
            'Name'           => $name,
            'Engine'         => 'Lucene',
            'Oid'            => $index['uuid'],
            'Rows'           => $index['total']['docs']['count'],
            'Auto_increment' => 0,
            'Data_length'    => $index['total']['store']['size_in_bytes'],
            'Index_length'   => 0,
            'Data_free'      => $index['total']['store']['reserved_in_bytes'],
        ];
    }

    function format_alias_status($name, $index)
    {
        return [
            'Name'   => $name,
            'Engine' => 'view',
            'Rows'   => $index['total']['docs']['count'],
        ];
    }

    function is_view($table_status)
    {
        return 'view' == $table_status['Engine'];
    }

    /** @param string $name
     * @return string[]
     */
    function view($name)
    {
        $return = connection()->rootQuery('_alias/' . urlencode($name));
        return ['select' => implode("\n", array_keys($return))];
    }

    function error()
    {
        return h(connection()->error);
    }

    function information_schema($db) {}

    function indexes($table, $connection2 = null)
    {
        return [
            ['type' => 'PRIMARY', 'columns' => ['_id']],
        ];
    }

    function fields($table)
    {
        $result  = [
            '_id' => [
                'field'      => '_id',
                'full_type'  => 'text',
                'type'       => 'text',
                'null'       => true,
                'sort'       => '_id',
                'privileges' => ['insert' => 1, 'select' => 1, 'where' => 1, 'order' => 1],
            ],
        ];
        $mapping = connection()->cachedQuery(urlencode($table) . '/_mapping');
        $index   = ($mapping ? first($mapping) : []); // the response is keyed by the index name, an alias is resolved by the server
        elastic_fields((array) $index['mappings']['properties'], '', $result);
        return $result;
    }

    /** Add fields of the mapping to the result, recurse into object and nested fields.
     * @param mixed[] $properties
     * @param mixed[] $result
     * @param mixed   $prefix
     * @param mixed   $nested
     */
    function elastic_fields(array $properties, $prefix, array &$result, $nested = false)
    {
        foreach ($properties as $name => $field)
        {
            $name          = "{$prefix}{$name}";

            if ($field['properties'])
            {
                elastic_fields($field['properties'], "{$name}.", $result, $nested || 'nested' == $field['type']);
                continue;
            }

            // text fields are not sortable, their keyword sub-field is
            $sort          = ('text' != $field['type'] ? $name : '');

            foreach ((array) $field['fields'] as $sub_name => $sub_field)
            {
                if ('' == $sort && 'keyword' == $sub_field['type'])
                {
                    $sort = "{$name}.{$sub_name}";
                }
            }

            $result[$name] = [
                'field'      => $name,
                'full_type'  => $field['type'],
                'type'       => $field['type'],
                'null'       => true,
                'sort'       => $sort,
                'privileges' => [
                    // a nested field holds a list of objects so a single column can not be edited, searched or sorted
                    'insert' => ! $nested ?: null,
                    'select' => 1,
                    'update' => ! $nested ?: null,
                    'where'  => ! $nested && ( ! isset($field['index']) || $field['index']) ?: null,
                    'order'  => ! $nested && '' != $sort ?: null,
                ],
            ];
        }
    }

    /** Get value of a field from the source of a document.
     * @param mixed  $source
     * @param string $path   dot separated
     *
     * @return mixed
     */
    function elastic_value($source, $path)
    {
        if ('' == $path || ! is_array($source))
        {
            return $source;
        }

        if (array_key_exists($path, $source)) // the document can use the dotted name directly
        {return $source[$path];
        }

        if (array_key_exists(0, $source)) // list of objects in a nested field
        {$return = [];

            foreach ($source as $item)
            {
                $return[] = elastic_value($item, $path);
            }
            return $return;
        }
        list($key, $rest) = explode('.', $path, 2) + [1 => ''];
        return array_key_exists($key, $source) ? elastic_value($source[$key], $rest) : null;
    }

    function foreign_keys($table)
    {
        return [];
    }

    function table($idf)
    {
        return $idf;
    }

    function idf_escape($idf)
    {
        return $idf;
    }

    function convert_field($field) {}

    function unconvert_field($field, $return)
    {
        return $return;
    }

    function fk_support($table_status) {}

    function found_rows($table_status, $where) {}

    /** @return string */
    function auto_increment()
    {
        return '';
    }

    /** Alter type.
     * @param mixed $table
     * @param mixed $name
     * @param mixed $fields
     * @param mixed $foreign
     * @param mixed $comment
     * @param mixed $engine
     * @param mixed $collation
     * @param mixed $auto_increment
     * @param mixed $partitioning
     *
     * @return mixed
     */
    function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning)
    {
        $properties = [];

        foreach ($fields as $f)
        {
            if ( ! $f[1])
            {
                continue; // the columns of the original mapping are sent without a name because they can be neither dropped nor altered
            }
            $field_name              = trim($f[1][0]);
            $field_type              = trim($f[1][1] ?: 'text');
            $properties[$field_name] = [
                'type' => $field_type,
            ];
        }

        if ( ! empty($properties))
        {
            $properties = ['properties' => $properties];
        }

        if ('' != $table)
        {
            if ($name != $table)
            {
                connection()->error = 'Renaming indexes is not supported.';
                return false;
            }
            return $properties ? connection()->rootQuery(urlencode($name) . '/_mapping', $properties, 'POST', true) : true;
        }
        return connection()->rootQuery(urlencode($name), ['mappings' => $properties], 'PUT', true);
    }

    /** @return bool */
    function drop_views(array $tables)
    {
        $return = connection()->rootQuery('_aliases', ['actions' => array_map(function ($table)
        {
            return ['remove' => ['index' => '*', 'alias' => $table]];
        }, $tables)], 'POST', true);
        return $return && ! $return['errors'];
    }

    /** @return bool */
    function drop_tables(array $tables)
    {
        $return = true;

        foreach ($tables as $table) // ! convert to bulk api
        {$return = $return && connection()->rootQuery(urlencode($table), null, 'DELETE', true);
        }
        return $return;
    }

    function last_id($result)
    {
        return connection()->last_id;
    }
}
