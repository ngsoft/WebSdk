<?php

namespace Adminer;

/** Use Codemirror 5 for syntax highlighting and SQL <textarea> including type-ahead of keywords and tables.
 * @see https://codemirror.net/5/
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerCodemirror
{
    protected $translations = [
        'cs' => ['' => 'Použít CodeMirror 5 pro zvýrazňování syntaxe a <textarea> včetně našeptávání klíčových slov a tabulek'],
        'de' => ['' => 'CodeMirror 5 verwenden für die Syntaxhervorhebung und <textarea> einschließlich der Überschrift von Schlüsselwörtern und Tabellen'],
        'ja' => ['' => 'CodeMirror 5 を用い、キーワードやテーブルを含む構文や <textarea> を強調表示'],
        'pl' => ['' => 'Użyj CodeMirror 5 do podświetlania składni i <textarea>, uwzględniając wcześniejsze wpisywanie słów kluczowych i tabel'],
        'hr' => ['' => 'Koristi CodeMirror 5 za isticanje sintakse i <textarea>, uključujući dovršavanje ključnih riječi i tablica'],
    ];
    private $root           = 'codemirror5';

    public function syntaxHighlighting($tableStatuses)
    {
        $connection = connection();
        ?>
        <style>
            @import url(<?= asset("{$this->root}/lib/codemirror.css"); ?>);
            @import url(<?= asset("{$this->root}/addon/hint/show-hint.css"); ?>);

            .CodeMirror {
                border: 1px inset #ccc;
                resize: both;
            }
        </style>
        <?php
        echo script_src(asset("{$this->root}/lib/codemirror.js"));
        echo script_src(asset("{$this->root}/addon/runmode/runmode.js"));
        echo script_src(asset("{$this->root}/addon/hint/show-hint.js"));
        echo script_src(asset("{$this->root}/mode/javascript/javascript.js"));

        $tables     = array_fill_keys(array_keys($tableStatuses), []);

        if (support('sql'))
        {
            echo script_src(asset("{$this->root}/mode/sql/sql.js"));
            echo script_src(asset("{$this->root}/addon/hint/sql-hint.js"));

            if (isset($_GET['sql']) || isset($_GET['trigger']) || isset($_GET['check']))
            {
                foreach (driver()->allFields() as $table => $fields)
                {
                    foreach ($fields as $field)
                    {
                        $tables[$table][] = $field['field'];
                    }
                }
            }
        }
        ?>
        <script <?= nonce(); ?>>
            addEventListener('DOMContentLoaded', () => {
                function getCmMode(el) {
                    const match = el.className.match(/(^|\s)jush-([^ ]+)/);
                    if (match) {
                        const modes = {
                            js: 'application/json',
                            sql: 'text/x-<?= 'maria' == $connection->flavor ? 'mariadb' : 'mysql'; ?>',
                            oracle: 'text/x-sql',
                            clickhouse: 'text/x-sql',
                            firebird: 'text/x-sql'
                        };
                        return modes[match[2]] || 'text/x-' + match[2];
                    }
                }

                adminerHighlighter = els => els.forEach(el => {
                    const mode = getCmMode(el);
                    if (mode) {
                        el.classList.add('cm-s-default');
                        CodeMirror.runMode(el.textContent, mode, el);
                    }
                });

                adminerHighlighter(qsa('code'));

                for (const el of qsa('textarea')) {
                    const mode = getCmMode(el);
                    if (mode) {
                        const width = el.clientWidth;
                        const height = el.clientHeight;
                        const cm = CodeMirror.fromTextArea(el, {
                            mode: mode,
                            extraKeys: {
                                'Ctrl-Space': 'autocomplete'
                            },
                            hintOptions: {
                                completeSingle: false,
                                tables: <?= json_encode($tables); ?>,
                                defaultTable: <?= json_encode($_GET['trigger'] ? $_GET['trigger'] : ($_GET['check'] ? $_GET['check'] : null)); ?>
                            }
                        });
                        cm.setSize(width, height);
                        cm.on('inputRead', () => {
                            const token = cm.getTokenAt(cm.getCursor());
                            if (/^[.`"\w]\w*$/.test(token.string)) {
                                CodeMirror.commands.autocomplete(cm);
                            }
                        });
                        setupSubmitHighlightInput(cm.getWrapperElement());
                        el.onchange = () => cm.setValue(el.value);
                    }
                }
            });
        </script>
        <?php
        return true;
    }
}
