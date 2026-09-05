<?php

namespace Adminer;

if ( ! class_exists('SimpleXMLElement') || ! ini_bool('allow_url_fopen'))
{
    return false;
}

add_driver('simpledb', 'SimpleDB');

if (isset($_GET['simpledb']))
{
    define('Adminer\DRIVER', 'simpledb');

    class Db extends SqlDb
    {
        public $extension   = 'SimpleXML';
        public $server_info = '2009-04-15';
        public $timeout;
        public $next;

        /** @return string */
        public function attach($server, $username, $password)
        {
            return '';
        }

        public function select_db($database)
        {
            return 'domain' == $database;
        }

        public function query($query, $unbuffered = false)
        {
            $params        = ['SelectExpression' => $query, 'ConsistentRead' => 'true'];

            if ($this->next)
            {
                $params['NextToken'] = $this->next;
            }
            $result        = sdb_request_all('Select', 'Item', $params, $this->timeout); // ! respect $unbuffered
            $this->timeout = 0;

            if (false === $result)
            {
                return $result;
            }

            if (preg_match('~^\s*SELECT\s+COUNT\(~i', $query))
            {
                $sum    = 0;

                foreach ($result as $item)
                {
                    $sum += $item->Attribute->Value;
                }
                $result = [(object) ['Attribute' => [(object) [
                    'Name'  => 'Count',
                    'Value' => $sum,
                ]]]];
            }
            return new Result($result);
        }

        /** @return string */
        public function quote($string)
        {
            return "'" . str_replace("'", "''", $string) . "'";
        }
    }

    class Result
    {
        public $num_rows;
        private $rows   = [];
        private $offset = 0;

        public function __construct($result)
        {
            foreach ($result as $item)
            {
                $row          = [];

                if ('' != $item->Name) // SELECT COUNT(*)
                {$row['itemName()'] = (string) $item->Name;
                }

                foreach ($item->Attribute as $attribute)
                {
                    $name  = $this->processValue($attribute->Name);
                    $value = $this->processValue($attribute->Value);

                    if (isset($row[$name]))
                    {
                        $row[$name]   = (array) $row[$name];
                        $row[$name][] = $value;
                    } else
                    {
                        $row[$name] = $value;
                    }
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
            return (object) ['name' => $keys[$this->offset++], 'type' => 15, 'charsetnr' => 0];
        }

        private function processValue($element)
        {
            return is_object($element) && 'base64' == $element['encoding'] ? base64_decode($element) : (string) $element;
        }
    }

    class Driver extends SqlDriver
    {
        public static $extensions = ['SimpleXML + allow_url_fopen'];
        public static $jush       = 'simpledb';
        public static $passwords  = false;

        public $operators         = ['=', '<', '>', '<=', '>=', '!=', 'LIKE', 'LIKE %%', 'IN', 'IS NULL', 'NOT LIKE', 'IS NOT NULL'];
        public $grouping          = ['count'];

        public $primary           = 'itemName()';

        /** Get the JUSH module inlined in the released driver by the release script.
         * @return string
         */
        public static function jushModule()
        {
            return ''; // the repository and the source archive load adminer/static/jush/modules/jush-simpledb.js
        }

        /** @param null|array $statements
         * @return string
         */
        public static function jushAutocomplete(array $tables, $statements)
        {
            return ''; // the queries are only a select expression and the columns are not known
        }

        public static function connect($server, $username, $password)
        {
            if ('' != $server && ! preg_match('~^(https?://)?[-a-z\d.]+(:\d+)?$~', $server))
            {
                return lang('Invalid server.');
            }
            return parent::connect($server, $username, $password); // the password is refused by Adminer::login()
        }

        public function select($table, array $select, array $where, array $group, array $order = [], $limit = 1, $page = 0, $print = false)
        {
            connection()->next = $_GET['next'];
            $_GET['next']      = ''; // set by sdb_request_all() if there is a following page
            $return            = parent::select($table, $select, $where, $group, $order, $limit, $page, $print);
            connection()->next = 0;
            return $return;
        }

        public function delete($table, $queryWhere, $limit = 0)
        {
            return $this->chunkRequest(
                $this->extractIds($table, $queryWhere, $limit),
                'BatchDeleteAttributes',
                ['DomainName' => $table]
            );
        }

        public function update($table, array $set, $queryWhere, $limit = 0, $separator = "\n")
        {
            $delete = [];
            $insert = [];
            $i      = 0;
            $ids    = $this->extractIds($table, $queryWhere, $limit);
            $id     = idf_unescape($set['`itemName()`']);
            unset($set['`itemName()`']);

            foreach ($set as $key => $val)
            {
                $key = idf_unescape($key);

                if ('NULL' == $val || ('' != $id && $ids != [$id]))
                {
                    $delete['Attribute.' . count($delete) . '.Name'] = $key;
                }

                if ('NULL' != $val)
                {
                    foreach ((array) $val as $k => $v)
                    {
                        $insert["Attribute.{$i}.Name"]  = $key;
                        $insert["Attribute.{$i}.Value"] = (is_array($val) ? $v : idf_unescape($v));

                        if ( ! $k)
                        {
                            $insert["Attribute.{$i}.Replace"] = 'true';
                        }
                        ++$i;
                    }
                }
            }
            $params = ['DomainName' => $table];
            return ( ! $insert || $this->chunkRequest('' != $id ? [$id] : $ids, 'BatchPutAttributes', $params, $insert))
                && ( ! $delete || $this->chunkRequest($ids, 'BatchDeleteAttributes', $params, $delete));
        }

        public function insert($table, array $set)
        {
            $params = ['DomainName' => $table];
            $i      = 0;

            foreach ($set as $name => $value)
            {
                if ('NULL' != $value)
                {
                    $name = idf_unescape($name);

                    if ('itemName()' == $name)
                    {
                        $params['ItemName'] = idf_unescape($value);
                    } else
                    {
                        foreach ((array) $value as $val)
                        {
                            $params["Attribute.{$i}.Name"]  = $name;
                            $params["Attribute.{$i}.Value"] = (is_array($value) ? $val : idf_unescape($value));
                            ++$i;
                        }
                    }
                }
            }
            return sdb_request('PutAttributes', $params);
        }

        public function insertUpdate($table, array $rows, array $primary)
        {
            // ! use one batch request
            foreach ($rows as $set)
            {
                if ( ! $this->update($table, $set, 'WHERE `itemName()` = ' . q($set['`itemName()`'])))
                {
                    return false;
                }
            }
            return true;
        }

        public function begin()
        {
            return false;
        }

        public function commit()
        {
            return false;
        }

        public function rollback()
        {
            return false;
        }

        public function slowQuery($query, $timeout)
        {
            $this->conn->timeout = $timeout;
            return $query;
        }

        private function chunkRequest($ids, $action, $params, $expand = [])
        {
            foreach (array_chunk($ids, 25) as $chunk)
            {
                $params2 = $params;

                foreach ($chunk as $i => $id)
                {
                    $params2["Item.{$i}.ItemName"] = $id;

                    foreach ($expand as $key => $val)
                    {
                        $params2["Item.{$i}.{$key}"] = $val;
                    }
                }

                if ( ! sdb_request($action, $params2))
                {
                    return false;
                }
            }
            connection()->affected_rows = count($ids);
            return true;
        }

        private function extractIds($table, $queryWhere, $limit)
        {
            $return = [];

            if (preg_match_all("~itemName\\(\\) = (('[^']*+')+)~", $queryWhere, $matches))
            {
                $return = array_map('Adminer\idf_unescape', $matches[1]);
            } else
            {
                foreach (sdb_request_all('Select', 'Item', ['SelectExpression' => 'SELECT itemName() FROM ' . table($table) . $queryWhere . ($limit ? ' LIMIT 1' : '')]) as $item)
                {
                    $return[] = $item->Name;
                }
            }
            return $return;
        }
    }

    function support($feature)
    {
        return preg_match('~^(cursor|sql)$~', $feature);
    }

    function logged_user()
    {
        $credentials = adminer()->credentials();
        return $credentials[1];
    }

    function get_databases($flush)
    {
        return ['domain'];
    }

    function collations()
    {
        return [];
    }

    function db_collation($db, $collations) {}

    function tables_list()
    {
        $return = [];

        foreach (sdb_request_all('ListDomains', 'DomainName') as $table)
        {
            $return[(string) $table] = 'table';
        }

        if (connection()->error && defined('Adminer\PAGE_HEADER'))
        {
            echo "<p class='error'>" . adminer()->error() . "\n";
        }
        return $return;
    }

    function table_status($name = '', $fast = false)
    {
        $return = [];

        foreach (('' != $name ? [$name => true] : tables_list()) as $table => $type)
        {
            $row            = ['Name' => $table, 'Auto_increment' => ''];

            if ( ! $fast)
            {
                $meta = sdb_request('DomainMetadata', ['DomainName' => $table]);

                if ($meta)
                {
                    foreach (
                        [
                            'Rows'         => 'ItemCount',
                            'Data_length'  => 'ItemNamesSizeBytes',
                            'Index_length' => 'AttributeValuesSizeBytes',
                            'Data_free'    => 'AttributeNamesSizeBytes',
                        ] as $key => $val
                    ) {
                        $row[$key] = (string) $meta->{$val};
                    }
                }
            }
            $return[$table] = $row;
        }
        return $return;
    }

    function explain($connection, $query) {}

    function error()
    {
        return h(connection()->error);
    }

    function information_schema($db) {}

    function indexes($table, $connection2 = null)
    {
        return [
            ['type' => 'PRIMARY', 'columns' => ['itemName()']],
        ];
    }

    function fields($table)
    {
        return fields_from_edit();
    }

    function foreign_keys($table)
    {
        return [];
    }

    function table($idf)
    {
        return idf_escape($idf);
    }

    function idf_escape($idf)
    {
        return '`' . str_replace('`', '``', $idf) . '`';
    }

    function limit($query, $where, $limit, $offset = 0, $separator = ' ')
    {
        return " {$query}{$where}" . ($limit ? $separator . "LIMIT {$limit}" : '');
    }

    function convert_field($field) {}

    function unconvert_field($field, $return)
    {
        return $return;
    }

    function fk_support($table_status) {}

    function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning)
    {
        return '' == $table && sdb_request('CreateDomain', ['DomainName' => $name]);
    }

    function drop_tables($tables)
    {
        foreach ($tables as $table)
        {
            if ( ! sdb_request('DeleteDomain', ['DomainName' => $table]))
            {
                return false;
            }
        }
        return true;
    }

    function count_tables($databases)
    {
        foreach ($databases as $db)
        {
            return [$db => count(tables_list())];
        }
    }

    function found_rows($table_status, $where)
    {
        return $where ? null : $table_status['Rows'];
    }

    function last_id($result) {}

    function sdb_request($action, $params = [])
    {
        list($host, $params['AWSAccessKeyId'], $secret) = adminer()->credentials();

        if ('' == $host)
        {
            $host = 'sdb.amazonaws.com';
        }
        $params['Action']                               = $action;
        $params['Timestamp']                            = gmdate('Y-m-d\TH:i:s+00:00');
        $params['Version']                              = '2009-04-15';
        $params['SignatureVersion']                     = 2;
        $params['SignatureMethod']                      = 'HmacSHA1';
        ksort($params);
        $query                                          = '';

        foreach ($params as $key => $val)
        {
            $query .= '&' . rawurlencode($key) . '=' . rawurlencode($val);
        }
        $query                                          = str_replace('%7E', '~', substr($query, 1));
        $query .= '&Signature=' . urlencode(base64_encode(hash_hmac('sha1', "POST\n" . preg_replace('~^https?://~', '', $host) . "\n/\n{$query}", $secret, true)));
        list($file)                                     = get_url(preg_match('~^https?://~', $host) ? $host : "http://{$host}", stream_context_create(['http' => [
            'method'          => 'POST', // may not fit in URL with GET
            'content'         => $query,
            'ignore_errors'   => 1,
            'follow_location' => 0,
            'max_redirects'   => 0,
        ]]));

        if ( ! $file)
        {
            connection()->error = lang('Invalid credentials.');
            return false;
        }
        libxml_use_internal_errors(true);
        libxml_disable_entity_loader();
        $xml                                            = simplexml_load_string($file);

        if ( ! $xml)
        {
            $error              = libxml_get_last_error();
            connection()->error = $error->message;
            return false;
        }

        if ($xml->Errors)
        {
            $error              = $xml->Errors->Error;
            connection()->error = "{$error->Message} ({$error->Code})";
            return false;
        }
        connection()->error                             = '';
        $tag                                            = $action . 'Result';
        return $xml->{$tag} ?: true;
    }

    function sdb_request_all($action, $tag, $params = [], $timeout = 0)
    {
        $return = [];
        $start  = ($timeout ? microtime(true) : 0);
        $limit  = (preg_match('~LIMIT\s+(\d+)\s*$~i', $params['SelectExpression'], $match) ? $match[1] : 0);

        do
        {
            $xml                 = sdb_request($action, $params);

            if ( ! $xml)
            {
                break;
            }

            foreach ($xml->{$tag} as $element)
            {
                $return[] = $element;
            }

            if ($limit && count($return) >= $limit)
            {
                $_GET['next'] = (string) $xml->NextToken;
                break;
            }

            if ($timeout && microtime(true) - $start > $timeout)
            {
                return false;
            }
            $params['NextToken'] = $xml->NextToken;

            if ($limit)
            {
                $params['SelectExpression'] = preg_replace('~\d+\s*$~', $limit - count($return), $params['SelectExpression']);
            }
        } while ($xml->NextToken);
        return $return;
    }
}
