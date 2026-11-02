<?php

namespace Adminer;

/** Type the columns in select with suggestions, also expressions like a+b.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerSelectExpression extends Plugin
{
    protected $functions;
    protected $lists        = []; // datalist index => columns
    protected $searching    = false;

    protected $translations = [
        'cs' => ['' => 'Umožní psát sloupce ve výpisu s výběrem, také výrazy jako a+b'],
        'de' => ['' => 'Ermöglicht das Eintippen der Spalten im Select mit Vorschlägen, auch Ausdrücke wie a+b'], // Claude Opus 5.5
        'ja' => ['' => '一覧で列を候補付きで入力可能にし、a+b のような式も使用可能'], // Claude Opus 5.5
        'pl' => ['' => 'Umożliwia wpisywanie kolumn w wyniku z podpowiedziami, także wyrażeń jak a+b'], // Claude Opus 5.5
        'ro' => ['' => 'Permite tastarea coloanelor în select cu sugestii, inclusiv expresii precum a+b'], // Claude Opus 5.5
        'sk' => ['' => 'Umožní písať stĺpce vo výpise s výberom, aj výrazy ako a+b'], // Claude Opus 5.5
        'zh' => ['' => '在选择数据时输入列并提供建议，也支持 a+b 这样的表达式'], // Claude Opus 5.5
    ];

    /**
     * @param list<string> $functions lowercase names of functions allowed in expressions besides the ones offered by Adminer, without side effects (links can contain them)
     */
    public function __construct(array $functions = [
        'abs', 'ceil', 'ceiling', 'floor', 'round', 'sign', 'sqrt', 'power', 'mod',
        'length', 'char_length', 'lower', 'upper', 'trim', 'ltrim', 'rtrim', 'substr', 'substring', 'concat',
        'coalesce', 'nullif', 'greatest', 'least',
        'date', 'year', 'month', 'day', 'count',
    ])
    {
        $this->functions = $functions;
    }

    public function selectColumnInput($attrs, $columns, $value = '', $placeholder = '')
    {
        $id = array_search($columns, $this->lists, true); // Select, Search and Sort share the list if they have the same privileges

        if (false === $id)
        {
            $id            = count($this->lists);
            $this->lists[] = $columns;
        }
        return "<input{$attrs} list='select-expression-{$id}' size='15' value='" . h($value) . "' placeholder='{$placeholder}'>";
    }

    public function selectActionPrint($indexes)
    {
        // not in the rows of the boxes which selectAddRow() clones
        foreach ($this->lists as $id => $columns)
        {
            echo "<datalist id='select-expression-{$id}'>" . optionlist($columns, null, true) . "</datalist>\n";
        }
    }

    public function selectColumnsProcess($columns, $indexes)
    {
        if ( ! $this->enabled())
        {
            return null;
        }
        $grouping = driver()->grouping;
        $select   = [];
        $group    = [];

        foreach ((array) $_GET['columns'] as $key => $val)
        {
            $fun = $val['fun'];
            $col = $val['col'];

            if ('count' == $fun || ('' != $col && ( ! $fun || in_array($fun, driver()->functions) || in_array($fun, $grouping))))
            {
                $expression   = ('' == $col || isset($columns[$col]) ? null : $this->expression($col, $columns));
                $sql          = apply_sql_function($fun, '' == $col ? '*' : ($expression ?: idf_escape($col)));
                // the typed text is the name of the result column, a function is aliased by Adminer in PostgreSQL and MS SQL
                $select[$key] = $sql . ($expression && ! $fun ? ' AS ' . idf_escape($col) : '');

                if ( ! in_array($fun, $grouping))
                {
                    $group[] = $sql;
                }
            }
        }
        return [$select, $group];
    }

    public function selectSearchProcess($fields, $indexes, $tableStatus = null)
    {
        if ($this->searching || ! $this->enabled())
        {
            return null;
        }
        $columns         = [];

        foreach ($fields as $name => $field)
        {
            if (isset($field['privileges']['where']))
            {
                $columns[$name] = $name;
            }
        }
        $operators       = adminer()->operators($tableStatus);
        $where           = (array) $_GET['where'];
        $conds           = [];

        foreach ($where as $key => $val)
        {
            $col        = $val['col'];
            $expression = ('' == $col || isset($fields[$col]) ? null : $this->expression($col, $columns));

            if ($expression)
            {
                unset($_GET['where'][$key]); // Adminer processes the other conditions
                $val += ['op' => first($operators), 'val' => ''];
                $where[$key] = $val;

                if (in_array($val['op'], $operators))
                {
                    if ('SQL' == $val['op'] && ( ! $_POST || ! verify_token()))
                    {
                        SqlDb::$untrusted = true; // the same as in Adminer
                    }
                    $conds[] = adminer()->selectSearchCondition($expression, $val['op'], $val['val']);
                }
            }
        }

        if (count($where) == count((array) $_GET['where']))
        {
            return null;
        }
        $this->searching = true;
        $return          = adminer()->selectSearchProcess($fields, $indexes, $tableStatus);
        $this->searching = false;

        foreach ($_GET['where'] as $key => $val)
        {
            $where[$key] = $val; // Adminer fills the defaults
        }
        $_GET['where']   = $where; // in the original order, used also by selectSearchPrint() and by the CSRF check of the SQL operator
        return array_merge($return, $conds);
    }

    public function selectOrderProcess($fields, $indexes)
    {
        if ( ! $this->enabled())
        {
            return null;
        }
        $columns = [];

        foreach ($fields as $name => $field)
        {
            if (isset($field['privileges']['order']))
            {
                $columns[$name] = $name;
            }
        }
        $return  = [];

        foreach ((array) $_GET['order'] as $key => $val)
        {
            if ('' != $val)
            {
                $function   = preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~', $val); // the same as in Adminer
                $expression = (isset($fields[$val]) || $function ? null : $this->expression($val, $columns));
                $return[]   = ($expression ?: ($function ? $val : idf_escape($val)))
                    . (isset($_GET['desc'][$key]) ? ' DESC' . (JUSH == 'pgsql' && idx($fields[$val], 'null') ? ' NULLS LAST' : '') : '');
            }
        }
        return $return;
    }

    public function screenshot()
    {
        return 'https://www.adminer.org/static/plugins/select-expression.webp';
    }

    /** Check whether the driver understands SQL expressions */
    protected function enabled()
    {
        return preg_match('~^(sql|pgsql|sqlite|mssql|oracle)$~', JUSH);
    }

    /** Build SQL from an expression containing only columns, literals, operators and allowed functions.
     * @param array<string, string> $columns allowed columns in keys
     * @param mixed                 $text
     *
     * @return ?string null if the text contains anything else
     */
    protected function expression($text, array $columns)
    {
        $quoted    = (JUSH == 'sql' ? '`(?:[^`]|``)*`' : '"(?:[^"]|"")*"' . (JUSH == 'mssql' ? '|\[(?:[^]]|]])*]' : ''));
        // 1 - string, 2 - quoted identifier, 3 - number, 4 - word, 5 - operator
        $pattern   = '~\G\s*+(?:(\'(?:[^\']|\'\')*\')|(' . $quoted . ')|([0-9]+(?:\.[0-9]+)?(?:[eE][-+]?[0-9]+)?)|([^\W\d]\w*)|(<=|>=|<>|!=|\|\||[-+*/%=<>(),]))~u';

        if ( ! preg_match_all($pattern, $text, $matches, PREG_SET_ORDER))
        {
            return null;
        }
        $length    = 0;

        foreach ($matches as $match)
        {
            $length += strlen($match[0]);
        }

        if ($length != strlen(rtrim($text)))
        {
            return null; // an unknown character, e.g. ; # @ $ : . ?
        }
        $keywords  = ['and', 'or', 'not', 'is', 'null', 'true', 'false', 'like', 'in', 'between', 'case', 'when', 'then', 'else', 'end', 'distinct'];
        $functions = array_merge($this->functions, driver()->functions, driver()->grouping);
        $return    = '';
        $depth     = 0;
        $glue      = false; // whether the previous token is followed by a space

        foreach ($matches as $i => $match)
        {
            $type  = count($match) - 1; // the last matched group
            $token = $match[$type];
            $sql   = $token;
            $space = true;

            if (1 == $type)
            {
                $sql = q(idf_unescape($token));
            } elseif (2 == $type)
            {
                $name = idf_unescape($token);

                if ( ! isset($columns[$name]))
                {
                    return null;
                }
                $sql  = idf_escape($name);
            } elseif (4 == $type)
            {
                $lower = strtolower($token);

                if (in_array($lower, $keywords))
                {
                    $sql = strtoupper($token);
                } elseif (isset($matches[$i + 1][5]) && '(' == $matches[$i + 1][5])
                {
                    if ( ! in_array($lower, $functions))
                    {
                        return null;
                    }
                    $sql   = strtoupper($token);
                    $space = false; // MySQL doesn't accept a space before the parenthesis of a function
                } elseif (isset($columns[$token]))
                {
                    $sql = idf_escape($token);
                } else
                {
                    return null;
                }
            } elseif ('(' == $token)
            {
                ++$depth;
                $space = false;
            } elseif (')' == $token)
            {
                --$depth;

                if ($depth < 0)
                {
                    return null; // the expression must not close the parentheses around it
                }
            }
            // two operators are always separated by a space so that they can't form a comment like -- or /*
            $return .= ($glue && ')' != $token && ',' != $token ? ' ' : '') . $sql;
            $glue  = $space;
        }
        return $depth ? null : "({$return})";
    }
}
