<?php

namespace Adminer;

/** Use Codemirror 5 for syntax highlighting and SQL <textarea> including type-ahead of keywords and tables
 * @link https://codemirror.net/5/
 * @link https://www.adminer.org/plugins/#use
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerCodemirror
{
    private $root = 'codemirror5';


    function syntaxHighlighting($tableStatuses)
    {
        $connection = connection();
        ?>
        <style>
            @import url(<?= asset("{$this->root}/lib/codemirror.css") ?>);
            @import url(<?= asset("{$this->root}/addon/hint/show-hint.css") ?>);

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
        if (support("sql")) {
            echo script_src(asset("{$this->root}/mode/sql/sql.js"));
            echo script_src(asset("{$this->root}/addon/hint/sql-hint.js"));
        }
        $tables = array();
        foreach ($tableStatuses as $status) {
            foreach (fields($status["Name"]) as $name => $field) {
                $tables[$status["Name"]][] = $name;
            }
        }
        ?>
        <script <?php echo nonce(); ?>>
            function getCmMode(el) {
                const match = el.className.match(/(^|\s)jush-([^ ]+)/);
                if (match) {
                    const modes = {
                        js: 'application/json',
                        sql: 'text/x-<?php echo($connection->flavor == "maria" ? "mariadb" : "mysql"); ?>',
                        oracle: 'text/x-sql',
                        clickhouse: 'text/x-sql',
                        firebird: 'text/x-sql'
                    };
                    return modes[match[2]] || 'text/x-' + match[2];
                }
            }

            for (const el of qsa('code')) {
                const mode = getCmMode(el);
                if (mode) {
                    el.classList.add('cm-s-default');
                    CodeMirror.runMode(el.textContent, mode, el);
                }
            }

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
                            tables: <?php echo json_encode($tables); ?>,
                            defaultTable: <?php echo json_encode($_GET["trigger"] ? $_GET["trigger"] : ($_GET["check"] ? $_GET["check"] : null)); ?>
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
                }
            }
        </script>
        <?php
        return true;
    }
}
