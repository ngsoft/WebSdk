<?php

namespace Adminer;

if ( ! class_exists('MongoDB\Driver\Manager'))
{
    return false;
}

add_driver('mongo', 'MongoDB alpha');

if (isset($_GET['mongo']))
{
    define('Adminer\DRIVER', 'mongo');

    class Db extends SqlDb
    {
        public $extension   = 'MongoDB';
        public $server_info = MONGODB_VERSION;
        public $last_id;
        /** @var \MongoDB\Driver\Manager */
        public $_link;
        public $_db;
        public $_db_name;

        /** @return string */
        public function attach($server, $username, $password)
        {
            $options     = [];

            if ('' != $username . $password)
            {
                $options['username'] = $username;
                $options['password'] = $password;
            }
            $db          = adminer()->database();

            if ('' != $db)
            {
                $options['db'] = $db;
            }
            $auth_source = getenv('MONGO_AUTH_SOURCE');

            if ( ! $auth_source)
            {
                // users are often allowed to authenticate only against the database they can access
                $auth_source = key((array) $_SESSION['db'][DRIVER][SERVER][$username]);
            }

            if ('' != $auth_source)
            {
                $options['authSource'] = $auth_source;
            }
            $this->_link = new \MongoDB\Driver\Manager("mongodb://{$server}", $options);
            $result      = (
                $options['username']
                ? $this->executeDbCommand($options['db'] ?: 'admin', ['ping' => 1]) // the connection is authenticated before running the command
                : $this->executeDbCommand('admin', ['listDatabases' => 1]) // ping doesn't require authentication so it would pass even on a server requiring it
            );
            return $result ? '' : $this->error;
        }

        public function executeCommand($command)
        {
            return $this->executeDbCommand($this->_db_name, $command);
        }

        public function executeDbCommand($db, $command)
        {
            try
            {
                return $this->_link->executeCommand($db, new \MongoDB\Driver\Command($command));
            } catch (\Exception $e)
            {
                $this->error = $e->getMessage();
                return [];
            }
        }

        public function executeBulkWrite($namespace, $bulk, $counter)
        {
            try
            {
                $results             = $this->_link->executeBulkWrite($namespace, $bulk);
                $this->affected_rows = $results->{$counter}();
                return true;
            } catch (\Exception $e)
            {
                $this->error = $e->getMessage();
                return false;
            }
        }

        public function query($query, $unbuffered = false)
        {
            return false;
        }

        public function select_db($database)
        {
            $this->_db_name = $database;
            return true;
        }

        /** @return string */
        public function quote($string)
        {
            return json_encode($string, 256); // 256 - JSON_UNESCAPED_UNICODE available since PHP 5.4
        }
    }

    class Result
    {
        public $num_rows;
        private $rows    = [];
        private $offset  = 0;
        private $charset = [];

        public function __construct($result)
        {
            foreach ($result as $item)
            {
                $row          = [];

                foreach ($item as $key => $val)
                {
                    if (is_a($val, 'MongoDB\BSON\Binary'))
                    {
                        $this->charset[$key] = 63;
                    }
                    $row[$key]
                        = (is_a($val, 'MongoDB\BSON\ObjectID') ? 'MongoDB\BSON\ObjectID("' . "{$val}\")"
                            : (is_a($val, 'MongoDB\BSON\UTCDatetime') ? $val->toDateTime()->format('Y-m-d H:i:s')
                                : (is_a($val, 'MongoDB\BSON\Binary') ? $val->getData() // ! allow downloading
                                    : (is_a($val, 'MongoDB\BSON\Regex') ? "{$val}"
                                        : (is_object($val) || is_array($val) ? json_encode($val, 256) // 256 - JSON_UNESCAPED_UNICODE available since PHP 5.4
                                            : $val))))); // MongoMinKey, MongoMaxKey
                }
                $this->rows[] = $row;

                foreach ($row as $key => $val)
                {
                    if ( ! isset($this->rows[0][$key]))
                    {
                        $this->rows[0][$key] = null;
                    }
                }
            }
            $this->num_rows = count($this->rows);
        }

        public function fetch_assoc()
        {
            $row    = current($this->rows);

            if ( ! $row)
            {
                return $row;
            }
            $return = [];

            foreach ($this->rows[0] as $key => $val)
            {
                $return[$key] = $row[$key];
            }
            next($this->rows);
            return $return;
        }

        public function fetch_row()
        {
            $return = $this->fetch_assoc();

            if ( ! $return)
            {
                return $return;
            }
            return array_values($return);
        }

        /** @return \stdClass */
        public function fetch_field()
        {
            $keys = array_keys($this->rows[0]);
            $name = $keys[$this->offset++];
            return (object) [
                'name'      => $name,
                'type'      => 15,
                'charsetnr' => $this->charset[$name],
            ];
        }
    }

    function get_databases($flush)
    {
        $return = [];

        foreach (connection()->executeCommand(['listDatabases' => 1]) as $dbs)
        {
            foreach ($dbs->databases as $db)
            {
                $return[] = $db->name;
            }
        }
        return $return;
    }

    function count_tables($databases)
    {
        return [];
    }

    function tables_list()
    {
        $collections = [];

        foreach (connection()->executeCommand(['listCollections' => 1]) as $result)
        {
            $collections[$result->name] = 'table';
        }
        return $collections;
    }

    function drop_databases($databases)
    {
        return false;
    }

    function indexes($table, $connection2 = null)
    {
        $return = [];

        foreach (connection()->executeCommand(['listIndexes' => $table]) as $index)
        {
            $descs                = [];
            $columns              = [];

            foreach (get_object_vars($index->key) as $column => $type)
            {
                $descs[]   = (-1 == $type ? '1' : null);
                $columns[] = $column;
            }
            $return[$index->name] = [
                'type'    => ('_id_' == $index->name ? 'PRIMARY' : (isset($index->unique) ? 'UNIQUE' : 'INDEX')),
                'columns' => $columns,
                'lengths' => [],
                'descs'   => $descs,
            ];
        }
        return $return;
    }

    function fields($table)
    {
        $driver = driver();
        $fields = fields_from_edit();

        if ( ! $fields)
        {
            $result = $driver->select($table, ['*'], [], [], [], 10);

            if ($result)
            {
                while ($row = $result->fetch_assoc())
                {
                    foreach ($row as $key => $val)
                    {
                        $row[$key]    = null;
                        $fields[$key] = [
                            'field'          => $key,
                            'type'           => 'string',
                            'null'           => ($key != $driver->primary),
                            'auto_increment' => ($key == $driver->primary),
                            'privileges'     => [
                                'insert' => 1,
                                'select' => 1,
                                'update' => 1,
                                'where'  => 1,
                                'order'  => 1,
                            ],
                        ];
                    }
                }
            }
        }
        return $fields;
    }

    function found_rows($table_status, $where)
    {
        $where   = where_to_query($where);
        $toArray = connection()->executeCommand(['count' => $table_status['Name'], 'query' => $where])->toArray();
        return $toArray[0]->n;
    }

    function sql_query_where_parser($queryWhere)
    {
        $queryWhere = preg_replace('~^\s*WHERE\s*~', '', $queryWhere);

        while ('(' == $queryWhere[0])
        {
            $queryWhere = preg_replace('~^\((.*)\)$~', '$1', $queryWhere);
        }

        $wheres     = explode(' AND ', $queryWhere);
        $wheresOr   = explode(') OR (', $queryWhere);
        $where      = [];

        foreach ($wheres as $whereStr)
        {
            $where[] = trim($whereStr);
        }

        if (1 == count($wheresOr))
        {
            $wheresOr = [];
        } elseif (count($wheresOr) > 1)
        {
            $where = [];
        }
        return where_to_query($where, $wheresOr);
    }

    /** Get value from an expression created by Db::quote().
     * @param mixed[]|string $expression array from the json function
     *
     * @return null|mixed[]|string null for expressions which are not values, e.g. NULL
     */
    function unquote($expression)
    {
        if (is_array($expression))
        {
            return $expression;
        }
        $return = json_decode($expression, true);
        return json_last_error() ? null : $return;
    }

    function where_to_query($whereAnd = [], $whereOr = [])
    {
        $data = [];

        foreach (['and' => $whereAnd, 'or' => $whereOr] as $type => $where)
        {
            if (is_array($where))
            {
                foreach ($where as $expression)
                {
                    list($col, $op, $val) = explode(' ', $expression, 3);
                    $val                  = unquote($val);

                    if ('_id' == $col && preg_match('~^(MongoDB\\\BSON\\\ObjectID)\("(.+)"\)$~', $val, $match))
                    {
                        list(, $class, $val) = $match;
                        $val                 = new $class($val);
                    }

                    if ( ! in_array($op, adminer()->operators()))
                    {
                        continue;
                    }

                    if (preg_match('~^\(f\)(.+)~', $op, $match))
                    {
                        $val = (float) $val;
                        $op  = $match[1];
                    } elseif (preg_match('~^\(date\)(.+)~', $op, $match))
                    {
                        $dateTime = new \DateTime($val);
                        $val      = new \MongoDB\BSON\UTCDatetime($dateTime->getTimestamp() * 1000);
                        $op       = $match[1];
                    }

                    switch ($op)
                    {
                        case '=':
                            $op = '$eq';
                            break;
                        case '!=':
                            $op = '$ne';
                            break;
                        case '>':
                            $op = '$gt';
                            break;
                        case '<':
                            $op = '$lt';
                            break;
                        case '>=':
                            $op = '$gte';
                            break;
                        case '<=':
                            $op = '$lte';
                            break;
                        case 'regex':
                            $op = '$regex';
                            break;
                        default:
                            continue 2;
                    }

                    if ('and' == $type)
                    {
                        $data['$and'][] = [$col => [$op => $val]];
                    } elseif ('or' == $type)
                    {
                        $data['$or'][] = [$col => [$op => $val]];
                    }
                }
            }
        }
        return $data;
    }

    class Driver extends SqlDriver
    {
        public static $extensions = ['mongodb'];
        public static $jush       = 'mongo';

        public $insertFunctions   = ['json'];

        public $operators         = [
            '=',
            '!=',
            '>',
            '<',
            '>=',
            '<=',
            'regex',
            '(f)=',
            '(f)!=',
            '(f)>',
            '(f)<',
            '(f)>=',
            '(f)<=',
            '(date)=',
            '(date)!=',
            '(date)>',
            '(date)<',
            '(date)>=',
            '(date)<=',
        ];

        public $primary           = '_id';

        public static function connect($server, $username, $password)
        {
            if ('' == $server)
            {
                $server = 'localhost:27017';
            }
            return parent::connect($server, $username, $password);
        }

        public function select($table, array $select, array $where, array $group, array $order = [], $limit = 1, $page = 0, $print = false)
        {
            $select  = (
                $select == ['*']
                ? []
                : array_fill_keys($select, 1)
            );

            if (count($select) && ! isset($select['_id']))
            {
                $select['_id'] = 0;
            }
            $where   = where_to_query($where);
            $sort    = [];

            foreach ($order as $val)
            {
                $val        = preg_replace('~ DESC$~', '', $val, 1, $count);
                $sort[$val] = ($count ? -1 : 1);
            }
            $options = ['projection' => $select, 'sort' => $sort];

            if ($limit) // 0 - all rows, used by export
            {$limit               = min(200, $limit);
                $options['limit'] = $limit;
                $options['skip']  = $page * $limit;
            }

            try
            {
                return new Result($this->conn->_link->executeQuery(
                    $this->conn->_db_name . ".{$table}",
                    new \MongoDB\Driver\Query($where, $options)
                ));
            } catch (\Exception $e)
            {
                $this->conn->error = $e->getMessage();
                return false;
            }
        }

        public function update($table, array $set, $queryWhere, $limit = 0, $separator = "\n")
        {
            $db           = $this->conn->_db_name;
            $where        = sql_query_where_parser($queryWhere);
            $bulk         = new \MongoDB\Driver\BulkWrite([]);

            if (isset($set['_id']))
            {
                unset($set['_id']);
            }
            $removeFields = [];

            foreach ($set as $key => $value)
            {
                $value = unquote($value);

                if (null === $value) // NULL and other expressions
                {$removeFields[$key] = 1;
                    unset($set[$key]);
                } else
                {
                    $set[$key] = $value;
                }
            }
            $update       = ['$set' => $set];

            if (count($removeFields))
            {
                $update['$unset'] = $removeFields;
            }
            $bulk->update($where, $update, ['upsert' => false]);
            return $this->conn->executeBulkWrite("{$db}.{$table}", $bulk, 'getModifiedCount');
        }

        public function delete($table, $queryWhere, $limit = 0)
        {
            $db    = $this->conn->_db_name;
            $where = sql_query_where_parser($queryWhere);
            $bulk  = new \MongoDB\Driver\BulkWrite([]);
            $bulk->delete($where, ['limit' => $limit]);
            return $this->conn->executeBulkWrite("{$db}.{$table}", $bulk, 'getDeletedCount');
        }

        public function insert($table, array $set)
        {
            $db   = $this->conn->_db_name;
            $bulk = new \MongoDB\Driver\BulkWrite([]);

            foreach ($set as $key => $value)
            {
                $value = unquote($value);

                if (null === $value) // NULL and other expressions
                {unset($set[$key]); // the field is not created at all
                } else
                {
                    $set[$key] = $value;
                }
            }

            if ('' == $set['_id'])
            {
                unset($set['_id']);
            }
            $bulk->insert($set);
            return $this->conn->executeBulkWrite("{$db}.{$table}", $bulk, 'getInsertedCount');
        }
    }

    function table($idf)
    {
        return $idf;
    }

    function idf_escape($idf)
    {
        return $idf;
    }

    function table_status($name = '', $fast = false)
    {
        $return = [];

        foreach (('' != $name ? [$name => 1] : tables_list()) as $table => $type)
        {
            $return[$table] = ['Name' => $table, 'Engine' => ''];
        }
        return $return;
    }

    function create_database($db, $collation)
    {
        return true;
    }

    function last_id($result)
    {
        return connection()->last_id;
    }

    function error()
    {
        return h(connection()->error);
    }

    function collations()
    {
        return [];
    }

    function logged_user()
    {
        $credentials = adminer()->credentials();
        return $credentials[1];
    }

    function alter_indexes($table, $alter)
    {
        foreach ($alter as $val)
        {
            list($type, $name, $set) = $val;

            if ('DROP' == $set)
            {
                $return = connection()->_db->command(['deleteIndexes' => $table, 'index' => $name]);
            } else
            {
                $columns = [];

                foreach ($set as $column)
                {
                    $column           = preg_replace('~ DESC$~', '', $column, 1, $count);
                    $columns[$column] = ($count ? -1 : 1);
                }
                $return  = connection()->_db->selectCollection($table)->ensureIndex($columns, [
                    'unique' => ('UNIQUE' == $type),
                    'name'   => $name,
                    // ! "sparse"
                ]);
            }

            if ($return['errmsg'])
            {
                connection()->error = $return['errmsg'];
                return false;
            }
        }
        return true;
    }

    function support($feature)
    {
        return preg_match('~database|indexes|descidx~', $feature);
    }

    function db_collation($db, $collations) {}

    function information_schema($db) {}

    function is_view($table_status) {}

    function convert_field($field) {}

    function unconvert_field($field, $return)
    {
        return $return;
    }

    function foreign_keys($table)
    {
        return [];
    }

    function fk_support($table_status) {}

    function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning)
    {
        if ('' == $table)
        {
            connection()->_db->createCollection($name);
            return true;
        }
    }

    function drop_tables($tables)
    {
        foreach ($tables as $table)
        {
            $response = connection()->_db->selectCollection($table)->drop();

            if ( ! $response['ok'])
            {
                return false;
            }
        }
        return true;
    }

    function truncate_tables($tables)
    {
        foreach ($tables as $table)
        {
            $response = connection()->_db->selectCollection($table)->remove();

            if ( ! $response['ok'])
            {
                return false;
            }
        }
        return true;
    }
}
