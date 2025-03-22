<?php

namespace Adminer;

/**
 * Autocomplete for keywords, tables and columns.
 * @author David Grudl
 * @license BSD
 */
class AdminerAutocomplete
{
    public $keywords = [
        'CREATE TABLE',
        'CREATE DATABASE',
        'PRIMARY KEY',
        'AUTO_INCREMENT',
        'IF NOT EXISTS',
        'DELETE FROM',
        'DISTINCT',
        'COUNT(*)',
        'EXPLAIN',
        'FROM',
        'GROUP BY',
        'HAVING',
        'INSERT INTO',
        'INNER JOIN',
        'IGNORE',
        'LIMIT',
        'OFFSET',
        'RIGHT JOIN',
        'LEFT JOIN',
        'NOT',
        'IN',
        'LIKE',
        'NULL',
        'ORDER BY',
        'ON DUPLICATE KEY UPDATE',
        'SELECT',
        'UPDATE',
        'WHERE',
        'SET',
        'VALUES',
        'BETWEEN',
        'AND',
        'OR',
        'ON',
        "=",
        "!=",
        "<>",
        ">",
        ">=",
        "<",
        "<=",
        "!<",
        "!>"
    ];


    public function head()
    {
        if (!isset($_GET['sql'])) {
            return;
        }

        $tables = [];
        $suggests = [];
        $fields = [];
        foreach (array_keys(tables_list()) as $table) {
            $tables[] = $table;
            foreach (fields($table) as $field => $foo) {
                $fields[] = $field;
                $suggests[] = "$table.$field";
            }
        } ?>
        <style <?= nonce(); ?>>
            .ace_editor {

                height: 500px;
                resize: both;
                border: 1px solid black;
                min-width: 715px;
                min-height: 500px;
                width: 715px;
            }

            .ace_text-input {
                font-family: "Fira Code Nerd Font Mono", "Fira Code", "Poppins", "Monaco", "Menlo", "Ubuntu Mono", "Consolas", "source-code-pro", monospace;
                /** /!\ we must disable ligatures for caret to be at the right position */
                font-variant-ligatures: none;
                font-feature-settings: "liga" 0;
            }
        </style>
        <script <?= nonce(); ?> src="static/ace/ace.js">
        </script>
        <script <?= nonce(); ?> src="static/ace/ext-language_tools.js">
        </script>
        <script <?= nonce(); ?>>
            document.addEventListener('DOMContentLoaded', () => {

                let keywords = <?= json_encode($this->keywords) ?>,
                    tables = <?= json_encode($tables) ?>,
                    fields = <?= json_encode($fields) ?>,
                    suggests = <?= json_encode($suggests) ?>,
                    textarea = document.querySelector('.sqlarea'),
                    form = textarea.form,
                    editor;

                ace.config.set('basePath', 'static/ace');
                editor = ace.edit(textarea);
                // editor.setTheme('ace/theme/tomorrow');
                editor.session.setMode('ace/mode/sql');
                editor.setOptions({
                    fontSize: 14,
                    enableBasicAutocompletion: [{
                        identifierRegexps: [/[a-zA-Z_0-9.\-\u00A2-\uFFFF<>!]/], // added dot
                        getCompletions: (editor, session, pos, prefix, callback) => {

                            // there is a limit to the length of the Array so we filter the results

                            let matches = [
                                ...keywords.map((word) => ({
                                    value: word + ' ',
                                    score: 1,
                                    meta: 'keyword'
                                }))
                                .filter(x => prefix.toLowerCase().startsWith(x.value.toLowerCase().slice(0, 1))),
                                ...tables.map((word) => ({
                                    value: word + ' ',
                                    score: 2,
                                    meta: 'table'
                                }))
                                .filter(() => prefix.toLowerCase() === prefix),
                                ...fields.map((word) => ({
                                    value: word + ' ',
                                    score: 2,
                                    meta: 'field'
                                })),
                                ...suggests.map((word) => ({
                                    value: word + ' ',
                                    score: 2,
                                    meta: 'field'
                                })),
                            ];

                            // add alias autocompletion
                            if (/[a-z]/.test(prefix)) {
                                matches.unshift(...fields.map((word) => ({
                                    value: `${prefix}.${word} `,
                                    score: 2,
                                    meta: 'field'
                                })));
                            }

                            // note, won't fire if caret is at a word that does not have these letters
                            callback(null, matches);
                        },
                    }],
                    // to make popup appear automatically, without explicit ctrl+space
                    enableLiveAutocompletion: true,
                });

                textarea.hidden = true;
                form.appendChild(textarea);
                editor.getSession().on('change', () => {
                    textarea.value = editor.getSession().getValue();
                });
            });
        </script>
<?php
    }
}
