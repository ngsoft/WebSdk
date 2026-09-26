<?php

/** Driver for https://api-docs.igdb.com/.
 * @see https://demo.adminer.org/igdb/?igdb=IGDB&db=api
 * username: your Client-ID
 * password: your Client Secret from https://dev.twitch.tv/console/apps
 * @see https://www.adminer.org/static/plugins/igdb.png
 */

namespace Adminer;

add_driver('igdb', 'APICalypse');

if (isset($_GET['igdb']))
{
    define('Adminer\DRIVER', 'igdb');

    class Db extends SqlDb
    {
        public $extension   = 'json';
        public $server_info = 'v4';
        private $username;
        private $token;

        public function attach(array $server, $username, $password)
        {
            $this->username = $username;
            $key            = $_COOKIE['adminer_key'];
            $hash           = md5($password); // the cached token must not be used with a different secret, otherwise any password would be accepted
            $cache          = get_session('igdb_token'); // hash of the secret, expiration, token encrypted the same way as the password

            if (idx($cache, 0) === $hash && $cache[1] > time())
            {
                $this->token = ($key ? decrypt_string($cache[2], $key) : $cache[2]);
            }

            if ( ! $this->token)
            {
                $url                               = 'https://id.twitch.tv/oauth2/token';
                $context                           = stream_context_create(['http' => [
                    'method'        => 'POST',
                    'header'        => 'Content-Type: application/x-www-form-urlencoded',
                    'content'       => http_build_query(['client_id' => $username, 'client_secret' => $password, 'grant_type' => 'client_credentials']),
                    'ignore_errors' => true,
                ]]);
                list($response, $status, , $error) = get_url($url, $context);
                $json                              = (array) json_decode($response, true); // idx() requires an array
                $this->token                       = $json['access_token'];

                if ( ! $this->token)
                {
                    return "{$url}: " . ($error ?: idx($json, 'message', "HTTP {$status}")); // the URL is a constant so displaying the response doesn't disclose anything
                }
                set_session('igdb_token', [$hash, time() + $json['expires_in'], $key ? encrypt_string($this->token, $key) : $this->token]);
            }
            return '';
        }

        public function select_db($database)
        {
            return 'api' == $database;
        }

        public function request($endpoint, $query, $method = 'POST')
        {
            $context                 = stream_context_create(['http' => [
                'method'        => $method,
                'header'        => [
                    'Content-Type: text/plain',
                    "Client-ID: {$this->username}",
                    "Authorization: Bearer {$this->token}",
                ],
                'content'       => $query,
                'ignore_errors' => true,
            ]]);
            list($response, $status) = get_url("https://api.igdb.com/v4/{$endpoint}", $context);
            $return                  = json_decode($response, true);

            if (200 != $status)
            {
                if (is_array($return))
                {
                    foreach (is_array($return[0]) ? $return : [$return] as $rows)
                    {
                        foreach ($rows as $key => $val)
                        {
                            $this->error .= '<b>' . h($key) . ':</b> ' . (is_url($val) ? '<a href="' . h($val) . '"' . target_blank() . '>' . h($val) . '</a>' : h($val)) . '<br>';
                        }
                    }
                } else
                {
                    $this->error = htmlspecialchars(strip_tags($response), 0, null, false);
                }
                return false;
            }
            return $return;
        }

        public function query($query, $unbuffered = false)
        {
            if (preg_match('~^SELECT COUNT\(\*\) FROM (\w+)( WHERE ((MATCH \(search\) AGAINST \((.+)\))|.+))?$~', $query, $match))
            {
                return new Result(['dumps' == $match[1] ? ['count' => 50] : $this->request("{$match[1]}/count", $match[5] ? 'search "' . addcslashes($match[5], '\"') . '";'
                    : (
                        $match[3] ? 'where ' . str_replace(' AND ', ' & ', $match[3]) . ';'
                    : ''
                    ))]);
            }

            if (preg_match('~^\s*(GET|POST|DELETE)\s+([\w/?=]+)\s*;\s*(.*)$~s', $query, $match))
            {
                $endpoint      = $match[2];
                $response      = $this->request($endpoint, $match[3], $match[1]);

                if (false === $response)
                {
                    return $response;
                }
                $return        = new Result(is_array($response[0]) ? $response : [$response]);
                $return->table = $endpoint;

                if ('multiquery' == $endpoint)
                {
                    $return->results = $response;
                }
                return $return;
            }
            $this->error = 'Syntax:<br>POST &lt;endpoint>; fields ...;';
            return false;
        }

        public function store_result()
        {
            if ($this->multi && ($result = current($this->multi->results)))
            {
                echo '<h3>' . h($result['name']) . "</h3>\n";
                $this->multi->__construct($result['count'] ? [['count' => $result['count']]] : $result['result']);
            }
            return $this->multi;
        }

        public function next_result()
        {
            return $this->multi && next($this->multi->results);
        }

        public function quote($string)
        {
            return $string;
        }
    }

    class Result
    {
        public $num_rows;
        public $table;
        public $results = [];
        private $result;
        private $fields;

        public function __construct(array $result)
        {
            $keys           = [];

            foreach ($result as $i => $row)
            {
                foreach ($row as $key => $val)
                {
                    $keys[$key] = null;

                    if (is_array($val) && is_int($val[0]))
                    {
                        $result[$i][$key] = '(' . implode(',', $val) . ')';
                    }
                }
            }

            foreach ($result as $i => $row)
            {
                $result[$i] = array_merge($keys, $row);
            }
            $this->result   = $result;
            $this->num_rows = count($result);
            $this->fields   = array_keys(idx($result, 0, []));
        }

        public function fetch_assoc()
        {
            $row = current($this->result);
            next($this->result);
            return $row;
        }

        public function fetch_row()
        {
            $row = $this->fetch_assoc();
            return $row ? array_values($row) : false;
        }

        public function fetch_field()
        {
            $field = current($this->fields);
            next($this->fields);
            return (object) ('' != $field ? ['name' => $field, 'orgtable' => $this->table] : []);
        }
    }

    class Driver extends SqlDriver
    {
        public static $extensions = ['json'];
        public static $jush       = 'igdb';

        public $delimiter         = ';;';
        public $tables            = [];
        public $links             = [];
        public $fields            = [];
        public $foreignKeys       = [];
        public $foundRows         = null;

        public function __construct(Db $connection)
        {
            parent::__construct($connection);
            libxml_use_internal_errors(true);
            $dom                       = new \DOMDocument();
            $dom->loadHTMLFile(self::docsFilename());
            $xpath                     = new \DOMXPath($dom);
            $els                       = $xpath->query('//div[@class="content"]/*');
            $link                      = '';

            foreach ($els as $i => $el)
            {
                if ('h2' == $el->tagName)
                {
                    $link = $el->getAttribute('id');
                }

                if ('Request Path' == $el->nodeValue)
                {
                    $table                      = preg_replace('~^https://api.igdb.com/v4/~', '', $els[$i + 1]->firstElementChild->nodeValue);
                    $comment                    = 'p' == $els[$i - 1]->tagName ? $els[$i - 1]->nodeValue : '';

                    if (preg_match('~^DEPRECATED!~', $comment))
                    {
                        continue;
                    }
                    $this->fields[$table]['id'] = ['full_type' => 'bigint', 'comment' => ''];
                    $this->links[$link]         = $table;
                    $this->tables[$table]       = ['Name' => $table, 'Engine' => 'endpoint', 'Comment' => $comment];

                    foreach ($xpath->query('tbody/tr', $els[$i + 2]) as $tr)
                    {
                        $tds     = $xpath->query('td', $tr);
                        $field   = $tds[0]->nodeValue;
                        $comment = $tds[2]->nodeValue;

                        if ('checksum' != $field && 'content_descriptions' != $field && ! preg_match('~^DEPRECATED!~', $comment))
                        {
                            $this->fields[$table][$field] = [
                                'full_type' => str_replace('  ', ' ', $tds[1]->nodeValue),
                                'comment'   => str_replace('  ', ' ', $comment),
                            ];
                            $ref                          = $xpath->query('a/@href', $tds[1]);

                            if (count($ref) && ! in_array($ref[0]->value, ['#game-version-feature-enums', '#tag-numbers']))
                            {
                                $this->foreignKeys[$table][$field] = substr($ref[0]->value, 1);
                            } elseif ('game_id' === $field) // game_time_to_beats, popularity_primitives
                            {$this->foreignKeys[$table][$field] = 'game';
                            }
                        }
                    }
                    uksort($this->fields[$table], function ($a, $b) use ($table)
                    {
                        return (('id' == $b) - ('id' == $a))
                            ?: (('name' == $b) - ('name' == $a))
                            ?: (('updated_at' == $a) - ('updated_at' == $b))
                            ?: (('created_at' == $a) - ('created_at' == $b))
                            ?: ( ! idx($this->foreignKeys[$table], $b) - ! idx($this->foreignKeys[$table], $a))
                            ?: ($a < $b ? -1 : 1);
                    });
                }
            }

            $this->tables['dumps']     = [
                'Name'    => 'dumps',
                'Engine'  => 'dumps',
                'Comment' => 'Daily updated CSV Data Dumps which can be used to kick start your projects or keep your data up to date (within 24 hours)',
            ];
            $this->links['data-dumps'] = 'dumps';
            $this->fields['dumps']     = [
                's3_url'         => ['comment' => 'The download Url is a presigned S3 url that is valid for 5 minutes'],
                'endpoint'       => [],
                'file_name'      => [],
                'size_bytes'     => [],
                'updated_at'     => ['full_type' => 'datetime'],
                'schema_version' => ['full_type' => 'datetime', 'comment' => 'Will change when the schema changes'],
                'schema'         => ['comment' => 'Reflects the current data structure and data type that the Dump is using'],
            ];

            $this->tables['webhooks']  = [
                'Name'    => 'webhooks',
                'Engine'  => 'webhooks',
                'Comment' => 'Webhooks allow us to push data to you when it is added, updated, or deleted',
            ];
            $this->links['webhooks']   = 'webhooks';
            $this->fields['webhooks']  = [
                'endpoint'     => [
                    'full_type'  => 'String',
                    'comment'    => 'Specify what type of data you want from your webhook',
                    'privileges' => ['insert' => 1],
                ],
                'id'           => ['comment' => 'A unique ID for the webhook'],
                'url'          => [
                    'full_type'  => 'String',
                    'length'     => '100',
                    'comment'    => 'Your prepared url that is ready to accept data from us',
                    'privileges' => ['select' => 1, 'insert' => 1],
                ],
                'method'       => [
                    'full_type'  => 'enum',
                    'length'     => "('create','delete','update')",
                    'comment'    => 'The type of data you are expecting to your url, there are three types of methods',
                    'privileges' => ['insert' => 1],
                ],
                'category'     => ['comment' => 'Based on the endpoint you chose'],
                'sub_category' => ['comment' => 'Based on your method (can be 0, 1, 2)'],
                'active'       => ['comment' => 'Is the webhook currently active'],
                'api_key'      => ['comment' => 'Displays the api key the webhook is connected to'],
                'secret'       => [
                    'full_type'  => 'String',
                    'comment'    => 'Your “secret” password for your webhook',
                    'privileges' => ['select' => 1, 'insert' => 1],
                ],
                'created_at'   => ['comment' => 'Created at date'],
                'updated_at'   => ['comment' => 'Updated at date'],
            ];
        }

        public function operators($tableStatus)
        {
            return ['=', '<', '>', '<=', '>=', '!=', '~'];
        }

        /** Get the JUSH module inlined in the released driver by the release script */
        public static function jushModule()
        {
            return <<<'JS'
jush.tr.igdb = { quo: /"/ };

jush.build_links2('igdb', 'https://api-docs.igdb.com/#$key', /(\b)/, /(\b)/gi, {
	'endpoints': /(POST|GET|DELETE)/,
	'$1': /(fields|exclude)/,
	'filters': /(where)/,
	'sorting': /(sort)/,
	'search-1': /(search)/,
	'pagination': /(limit|offset)/,
	'multi-query': /(query)/,
});
JS;
        }

        public static function jushAutocomplete(array $tables, $statements)
        {
            return ''; // the queries are not SQL
        }

        public static function connect($server, $username, $password)
        {
            $filename = self::docsFilename();

            if ( ! file_exists($filename))
            {
                list($contents, $status) = get_url('https://api-docs.igdb.com/', stream_context_create(['http' => ['ignore_errors' => true]]));

                if (200 != $status || ! file_put_contents($filename, $contents))
                {
                    return "Download https://api-docs.igdb.com/ and save it as {$filename}";
                }
            }
            return parent::connect($server, $username, $password);
        }

        public static function disconnect()
        {
            set_session('igdb_token', null);
        }

        public function fulltextSql($name, array $index, $query, $boolean)
        {
            return 'search "' . addcslashes($query, '\"') . '"';
        }

        public function select($table, array $select, array $where, array $group, array $order = [], $limit = 1, $page = 0, $print = false)
        {
            $query           = '';
            $search          = preg_match('~^search "~', $where[0]); // the condition built by fulltextSql()

            if ($search)
            {
                $query = "{$where[0]};\n";
                unset($where[0]);
            }

            foreach ($where as $i => $val)
            {
                $where[$i] = str_replace(' OR ', ' | ', $val);
            }
            $limit           = ($limit ?: 500); // 0 - all rows, used by export; 500 is the maximum accepted by the API, it has no way to get more
            $columns         = ($select != ['*'] ? $select : array_keys($this->fields[$table]));
            $common          = ($where ? "\nwhere " . implode(' & ', $where) . ';' : '');
            $method          = ('webhooks' == $table || 'dumps' == $table ? 'GET' : 'POST');

            if ('POST' == $method)
            {
                $query .= 'fields ' . implode(',', $select) . ';'
                    . ($select == ['*'] ? "\nexclude checksum;" : '')
                    . $common
                    . ($order ? "\nsort " . strtolower(implode(',', $order)) . ';' : '')
                    . "\nlimit {$limit};"
                    . ($page ? "\noffset " . ($page * $limit) . ';' : '');
            }
            $start           = microtime(true);
            $multi           = ( ! $search && 'POST' == $method && array_key_exists($table, driver()->tables));
            $realQuery       = str_replace("*;\nexclude checksum", implode(',', $columns), $query); // exclude deprecated columns
            $return          = (
                $multi
                ? $this->conn->request('multiquery', "query {$table} \"result\" { {$realQuery} };\nquery {$table}/count \"count\" { {$common} };")
                : $this->conn->request('GET' == $method && $where ? "{$table}/" . reset($_GET['where']) : $table, $realQuery, $method)
            );
            $this->query     = "{$method} {$table};\n{$query}";

            if ($print)
            {
                echo adminer()->selectQuery($this->query, $start);
            }

            if (false === $return)
            {
                return $return;
            }
            $this->foundRows = ($multi ? $return[1]['count'] : null);
            $return          = ($multi ? $return[0]['result'] : $return);

            if ('dumps' == $table && $where)
            {
                $return = [$return];
            } elseif ($return && 'POST' == $method)
            {
                $return[0] = array_merge(array_fill_keys($columns, null), $return[0]);
            }
            return new Result($return);
        }

        public function insert($table, array $set)
        {
            $content = [];

            foreach ($set as $key => $val)
            {
                if ('endpoint' != $key)
                {
                    $content[] = urlencode($key) . '=' . urlencode($val);
                }
            }
            return queries("POST {$set['endpoint']}/{$table}; " . implode('&', $content));
        }

        public function delete($table, $queryWhere, $limit = 0)
        {
            preg_match_all('~\bid = (\d+)~', $queryWhere, $matches);
            $this->conn->affected_rows = 0;

            foreach ($matches[1] as $id)
            {
                $result = queries("DELETE {$table}/{$id};");

                if ( ! $result)
                {
                    return false;
                }
                $row    = $result->fetch_row();

                if ( ! $row[0])
                {
                    $this->conn->error = "ID {$id} not found.";
                    return false;
                }
                ++$this->conn->affected_rows;
            }
            return true;
        }

        public function value($val, array $field)
        {
            return $val && in_array($field['full_type'], ['Unix Time Stamp', 'datetime']) ? str_replace(' 00:00:00', '', gmdate('Y-m-d H:i:s', (int) $val)) : $val;
        }

        public function tableHelp($name, $is_view = false)
        {
            return strtolower('https://api-docs.igdb.com/#' . array_search($name, $this->links));
        }

        private static function docsFilename()
        {
            return get_temp_dir() . '/adminer-igdb-api.html';
        }
    }

    function logged_user()
    {
        return $_GET['username'];
    }

    function get_databases($flush)
    {
        return ['api'];
    }

    function collations()
    {
        return [];
    }

    function db_collation($db, array $collations) {}

    function information_schema($db) {}

    function indexes($table, $connection2 = null)
    {
        $return = [['type' => 'PRIMARY', 'columns' => ['dumps' == $table ? 'endpoint' : 'id']]];

        if (in_array($table, ['characters', 'collections', 'games', 'platforms', 'themes'])) // https://api-docs.igdb.com/#search-1
        {$return[] = ['type' => 'FULLTEXT', 'columns' => ['search']];
        }
        return $return;
    }

    function fields($table)
    {
        $return = [];

        foreach (driver()->fields[$table] ?: [] as $key => $val)
        {
            $type         = strtolower(preg_replace('~ .*~', '', $val['full_type']));
            $return[$key] = $val + [
                'field'      => $key,
                'type'       => ('reference' == $type ? 'int' : $type), // align right reference columns
                'privileges' => ['select' => 1] + ('webhooks' == $table || 'dumps' == $table ? [] : ['where' => 1, 'order' => 1]),
            ];
        }
        return $return;
    }

    function convert_field(array $field) {}

    function unconvert_field(array $field, $return)
    {
        return $return;
    }

    function limit($query, $where, $limit, $offset = 0, $separator = ' ')
    {
        return $query;
    }

    function limit1($table, $query, $where, $separator = "\n")
    {
        return limit($query, $where, 1, 0, $separator);
    }

    function idf_escape($idf)
    {
        return $idf;
    }

    function table($idf)
    {
        return idf_escape($idf);
    }

    function foreign_keys($table)
    {
        $return = [];

        foreach (driver()->foreignKeys[$table] ?: [] as $key => $val)
        {
            $return[] = [
                'table'  => driver()->links[$val],
                'source' => [$key],
                'target' => ['id'],
            ];
        }
        return $return;
    }

    function tables_list()
    {
        return array_fill_keys(array_keys(table_status()), 'table');
    }

    function table_status($name = '', $fast = false)
    {
        $tables = driver()->tables;
        return '' != $name ? ($tables[$name] ? [$name => $tables[$name]] : []) : $tables;
    }

    function count_tables(array $databases)
    {
        return [reset($databases) => count(tables_list())];
    }

    function error()
    {
        return connection()->error;
    }

    function explain(Db $connection, $query) {}

    function is_view(array $table_status)
    {
        return false;
    }

    function found_rows(array $table_status, array $where)
    {
        return driver()->foundRows;
    }

    function fk_support(array $table_status)
    {
        return true;
    }

    function last_id($result)
    {
        $row = $result->fetch_assoc();
        return (string) $row['id'];
    }

    function support($feature)
    {
        return in_array($feature, ['columns', 'comment', 'single_db', 'sql', 'table']);
    }
}
