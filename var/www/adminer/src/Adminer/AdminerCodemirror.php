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
class AdminerCodemirror extends Plugin
{
    protected $translations = [
        'cs' => ['' => 'Použít CodeMirror 5 pro zvýrazňování syntaxe a <textarea> včetně našeptávání klíčových slov a tabulek'],
        'de' => ['' => 'CodeMirror 5 verwenden für die Syntaxhervorhebung und <textarea> einschließlich Autovervollständigung von Schlüsselwörtern und Tabellen'],
        'hr' => ['' => 'Koristi CodeMirror 5 za isticanje sintakse i <textarea>, uključujući dovršavanje ključnih riječi i tablica'],
        'ja' => ['' => 'CodeMirror 5 を用い、キーワードやテーブル名の補完を含む構文強調表示と <textarea> を提供'],
        'pl' => ['' => 'Użyj CodeMirror 5 do podświetlania składni i <textarea>, wraz z podpowiadaniem słów kluczowych i nazw tabel'],
        'ro' => ['' => 'Folosiți CodeMirror 5 pentru evidențierea sintaxei și <textarea>, inclusiv sugestii pentru cuvinte cheie și tabele'],
        'sk' => ['' => 'Použije CodeMirror 5 na zvýrazňovanie syntaxe a <textarea> vrátane napovedania kľúčových slov a tabuliek'],
        'zh' => ['' => '使用 CodeMirror 5 实现语法高亮和 <textarea>，包含关键字和表名的输入提示'],
    ];

    /** Local bundled assets (not CDN). */
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

            .adminer-error-line {
                background: #fc05;
            }
        </style>
        <?php
        echo script_src(asset("{$this->root}/lib/codemirror.js"));
        echo script_src(asset("{$this->root}/addon/runmode/runmode.js"));
        echo script_src(asset("{$this->root}/addon/hint/show-hint.js"));
        echo script_src(asset("{$this->root}/mode/javascript/javascript.js"));

        $tables     = [];

        foreach ($tableStatuses as $table => $status)
        {
            if ( ! idx($status, 'dependent'))
            {
                $tables[$table] = [];
            }
        }

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
                        // Custom: no autocomplete on JSON editors
                        const isJson = mode === 'application/json';
                        const cm = CodeMirror.fromTextArea(el, {
                            mode: mode,
                            extraKeys: isJson ? {} : {
                                'Ctrl-Space': 'autocomplete'
                            },
                            hintOptions: {
                                completeSingle: false,
                                tables: <?= json_encode($tables); ?>,
                                defaultTable: <?= json_encode($_GET['trigger'] ?: ($_GET['check'] ?: null)); ?>
                            }
                        });
                        cm.setSize(width, height);
                        // Custom: keep the underlying textarea in sync — Adminer ajaxForm
                        // serializes fields without firing the form "submit" event
                        // that CodeMirror.fromTextArea normally hooks.
                        cm.on('changes', () => cm.save());
                        if (!isJson) {
                            cm.on('inputRead', () => {
                                const token = cm.getTokenAt(cm.getCursor());
                                if (/^[.`"\w]\w*$/.test(token.string)) {
                                    CodeMirror.commands.autocomplete(cm);
                                }
                            });
                        }
                        setupSubmitHighlightInput(cm.getWrapperElement());
                        el.onchange = () => cm.setValue(el.value);
                        const errorLine = el.dataset.errorLine - 1; // NaN without the attribute
                        if (errorLine >= 0) {
                            cm.addLineClass(errorLine, 'background', 'adminer-error-line');
                            cm.scrollIntoView({ line: errorLine, ch: 0 }, height / 3);
                            const unmark = () => {
                                cm.removeLineClass(errorLine, 'background', 'adminer-error-line');
                                cm.off('change', unmark);
                            };
                            cm.on('change', unmark);
                        }
                    }
                }
            });
        </script>
        <?php
        return true;
    }

    public function screenshot()
    {
        return 'https://www.adminer.org/static/plugins/codemirror.gif';
    }
}
