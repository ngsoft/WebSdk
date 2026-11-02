<?php

/** Experimental driver for IMAP created just for fun. Features:
 * - list mailboxes with number of messages (Rows) and unread messages (Data Free)
 * - creating and dropping mailboxes work, truncate does expunge on all mailboxes
 * - list messages in each mailbox - limit and offset works but there's no search and order
 * - for each message, there's subject, from, to, date and some flags
 * - editing the message shows some other information
 * - deleting marks the message for deletion but doesn't expunge the mailbox
 * - inserting or updating the message does nothing.
 *
 * @see https://www.adminer.org/static/plugins/imap.webp
 */

namespace Adminer;

add_driver('imap', 'IMAP');

if (isset($_GET['imap']))
{
    define('Adminer\DRIVER', 'imap');

    if (extension_loaded('imap'))
    {
        class Db extends SqlDb
        {
            public $extension   = 'IMAP';
            public $server_info = '?'; // imap_mailboxmsginfo() or imap_check() don't return anything useful
            private $mailbox;
            private $imap;

            public function attach(array $server, $username, $password)
            {
                $this->mailbox = '{' . "{$server['host']}:" . ($server['port'] ?: 993) . '/ssl}';
                $this->imap    = @imap_open($this->mailbox, $username, $password, OP_HALFOPEN, 1);
                return $this->imap ? '' : imap_last_error();
            }

            public function select_db($database)
            {
                return 'mail' == $database;
            }

            public function query($query, $unbuffered = false)
            {
                if (preg_match('~DELETE FROM "(.+?)"~', $query))
                {
                    preg_match_all('~"uid" = (\d+)~', $query, $matches);
                    return imap_delete($this->imap, implode(',', $matches[1]), FT_UID);
                }

                if (preg_match('~^SELECT COUNT\(\*\)\sFROM "(.+?)"~s', $query, $match))
                {
                    $status = table_status1($match[1]);
                    return new Result([[$status['Rows']]]);
                }

                if (preg_match('~^SELECT (.+)\sFROM "(.+?)"(?:\sWHERE "uid" = (\d+))?.*?(?:\sLIMIT (\d+)(?:\sOFFSET (\d+))?)?~s', $query, $match))
                {
                    list(, $columns, $table, $uid, $limit, $offset) = $match;
                    imap_reopen($this->imap, $this->mailbox . $table);

                    if ($uid)
                    {
                        $return = [(array) imap_fetchstructure($this->imap, $uid, FT_UID)];
                    } else
                    {
                        $count   = imap_num_msg($this->imap);
                        $range   = ($offset + 1) . ':' . ($limit ? min($count, $offset + $limit) : $count);
                        $return  = [];
                        $fields  = fields($table);
                        $columns = ('*' == $columns ? $fields : array_flip(explode(', ', $columns)));
                        $empty   = array_fill_keys(array_keys($fields), null);

                        foreach (imap_fetch_overview($this->imap, $range) as $row)
                        {
                            // imap_utf8 doesn't work with some strings
                            $row->subject = iconv_mime_decode($row->subject, 2, 'utf-8');
                            $row->from    = iconv_mime_decode($row->from, 2, 'utf-8');
                            $row->to      = iconv_mime_decode($row->to, 2, 'utf-8');
                            $row->udate   = gmdate('Y-m-d H:i:s', $row->udate);
                            $return[]     = array_intersect_key(array_merge($empty, (array) $row), $columns);
                        }
                    }
                    return new Result($return);
                }
                return false;
            }

            public function quote($string)
            {
                return $string;
            }

            public function tables_list()
            {
                static $return;

                if (null === $return)
                {
                    $return = [];

                    foreach (imap_list($this->imap, $this->mailbox, '*') as $val)
                    {
                        $return[substr($val, strlen($this->mailbox))] = 'table';
                    }
                }
                return array_reverse($return);
            }

            public function table_status($name, $fast)
            {
                if ($fast)
                {
                    return ['Name' => $name];
                }
                $return = imap_status($this->imap, $this->mailbox . $name, SA_ALL);
                return [
                    'Name'           => $name,
                    'Rows'           => $return->messages,
                    'Auto_increment' => $return->uidnext,
                    'Data_length'    => $return->messages, // this is used on database overview
                    'Data_free'      => $return->unseen,
                ];
            }

            public function create($name)
            {
                return imap_createmailbox($this->imap, $this->mailbox . $name);
            }

            public function drop($name)
            {
                return imap_deletemailbox($this->imap, $this->mailbox . $name);
            }

            public function expunge()
            {
                return imap_expunge($this->imap);
            }
        }

        class Result
        {
            public $num_rows;
            private $result;
            private $fields;

            public function __construct(array $result)
            {
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
                return (object) ('' != $field ? ['name' => $field] : []);
            }
        }
    }

    class Driver extends SqlDriver
    {
        public static $extensions  = ['IMAP'];
        public static $jush        = 'imap';
        public static $serverPorts = [993];

        public $insertFunctions    = ['json'];
    }

    function logged_user()
    {
        return $_GET['username'];
    }

    function get_databases($flush)
    {
        return ['mail'];
    }

    function collations()
    {
        return [];
    }

    function db_collation($db, array $collations) {}

    function information_schema($db)
    {
        return false;
    }

    function indexes($table, $connection2 = null)
    {
        return [['type' => 'PRIMARY', 'columns' => ['uid']]];
    }

    function fields($table)
    {
        $return = [];

        foreach (
            [ // taken from imap_fetch_overview, documented by RFC 5322 (message) and RFC 9051 (IMAP)
                'subject'     => ['the messages subject', 'rfc5322.html#section-3.6.5'],
                'from'        => ['who sent it', 'rfc5322.html#section-3.6.2'],
                'to'          => ['recipient', 'rfc5322.html#section-3.6.3'],
                'date'        => ['when was it sent', 'rfc5322.html#section-3.6.1'],
                'message_id'  => ['Message-ID', 'rfc5322.html#section-3.6.4'],
                'references'  => ['is a reference to this message id', 'rfc5322.html#section-3.6.4'],
                'in_reply_to' => ['is a reply to this message id', 'rfc5322.html#section-3.6.4'],
                'size'        => ['size in bytes', 'rfc9051.html#section-2.3.4'],
                'uid'         => ['UID the message has in the mailbox', 'rfc9051.html#section-2.3.1.1'],
                'msgno'       => ['message sequence number in the mailbox', 'rfc9051.html#section-2.3.1.2'],
                'recent'      => ['flagged as recent', 'rfc9051.html#section-2.3.2'],
                'flagged'     => ['flagged', 'rfc9051.html#section-2.3.2'],
                'answered'    => ['flagged as answered', 'rfc9051.html#section-2.3.2'],
                'deleted'     => ['flagged for deletion', 'rfc9051.html#section-2.3.2'],
                'seen'        => ['flagged as already read', 'rfc9051.html#section-2.3.2'],
                'draft'       => ['flagged as being a draft', 'rfc9051.html#section-2.3.2'],
                'udate'       => ['the GMT time of the arrival date', 'rfc9051.html#section-2.3.3'],
            ] as $name => $val
        ) {
            $return[$name] = [
                'field'      => $name,
                'type'       => (preg_match('~^(size|uid|msgno)$~', $name) ? 'int' : ''),
                'privileges' => ['select' => 1],
                'comment'    => $val[0],
                'doc'        => "https://www.rfc-editor.org/rfc/{$val[1]}",
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
        return " {$query}{$where}" . ($limit ? $separator . "LIMIT {$limit}" . ($offset ? " OFFSET {$offset}" : '') : '');
    }

    function limit1($table, $query, $where, $separator = "\n")
    {
        return limit($query, $where, 1, 0, $separator);
    }

    function idf_escape($idf)
    {
        return '"' . str_replace('"', '""', $idf) . '"';
    }

    function table($idf)
    {
        return idf_escape($idf);
    }

    function foreign_keys($table)
    {
        return [];
    }

    function tables_list()
    {
        return connection()->tables_list();
    }

    function table_status($name = '', $fast = false)
    {
        $return = [];

        foreach (('' != $name ? [$name => 1] : tables_list()) as $table => $type)
        {
            $return[$table] = connection()->table_status($table, $fast);
        }
        return $return;
    }

    function count_tables(array $databases)
    {
        return [reset($databases) => count(tables_list())];
    }

    function error()
    {
        return h(connection()->error);
    }

    function is_view(array $table_status)
    {
        return false;
    }

    function last_id($result) {}

    function found_rows(array $table_status, array $where)
    {
        return $table_status['Rows'];
    }

    function fk_support(array $table_status) {}

    function alter_table($table, $name, array $fields, array $foreign, $comment, $engine, $collation, $auto_increment, $partitioning)
    {
        return connection()->create($name);
    }

    function drop_tables(array $tables)
    {
        $return = true;

        foreach ($tables as $name)
        {
            $return = $return && connection()->drop($name);
        }
        return $return;
    }

    function truncate_tables(array $tables)
    {
        return connection()->expunge();
    }

    function support($feature)
    {
        return false;
    }
}
