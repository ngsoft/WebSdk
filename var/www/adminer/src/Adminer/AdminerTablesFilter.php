<?php

namespace Adminer;

/** Filter names in tables list.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerTablesFilter
{
    protected $translations = [
        'cs' => ['' => 'Filtruje názvy v seznamu tabulek'],
        'de' => ['' => 'Filtern Sie Namen in der Tabellenliste'],
        'pl' => ['' => 'Filtruj nazwy na liście tabel'],
        'ro' => ['' => 'Nume de filtre în lista de tabele'],
        'ja' => ['' => 'テーブル一覧をテーブル名でフィルタリング'],
    ];

    public function tablesPrint($tables)
    {
        ?>
        <script<?= nonce(); ?>>
            let tablesFilterTimeout = null;
            let tablesFilterValue = '';

            function tablesFilter() {
                const value = qs('#filter-field').value.toLowerCase();
                if (value == tablesFilterValue) {
                    return;
                }
                tablesFilterValue = value;
                let reg;
                if (value != '') {
                    reg = (value + '').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, '\\$1');
                    reg = new RegExp('(' + reg + ')', 'gi');
                }
                if (sessionStorage) {
                    sessionStorage.setItem('adminer_tables_filter', value);
                }
                for (const table of qsa('li', qs('#tables'))) {
                    let a = null;
                    let text = table.getAttribute('data-table-name');
                    if (text == null) {
                        a = qsa('a', table)[1];
                        text = a.innerHTML.trim();

                        table.setAttribute('data-table-name', text);
                        a.setAttribute('data-link', 'main');
                    } else {
                        a = qs('a[data-link="main"]', table);
                    }
                    if (value == '') {
                        table.className = '';
                        a.innerHTML = text;
                    } else {
                        table.className = (text.toLowerCase().indexOf(value) == -1 ? 'hidden' : '');
                        a.innerHTML = text.replace(reg, '<strong>$1</strong>');
                    }
                }
            }

            function tablesFilterInput() {
                window.clearTimeout(tablesFilterTimeout);
                tablesFilterTimeout = window.setTimeout(tablesFilter, 200);
            }

            sessionStorage && document.addEventListener('DOMContentLoaded', () => {
                let db = qs('#dbs').querySelector('select');
                db = db.options[db.selectedIndex].text;
                if (db == sessionStorage.getItem('adminer_tables_filter_db') && sessionStorage.getItem('adminer_tables_filter')) {
                    qs('#filter-field').value = sessionStorage.getItem('adminer_tables_filter');
                    tablesFilter();
                }
                sessionStorage.setItem('adminer_tables_filter_db', db);
            });


        </script>
        <style <?= nonce(); ?>>
            .js-only {
                padding: 4px 8px;
                display: flex;
                justify-content: flex-start;

                label {
                    display: none;
                }

                [type="search"] {
                    width: 80%;
                }
            }
        </style>
        <p class="js-only">
            <label for="filter-field"></label>
            <input placeholder="Search table" value="" id="filter-field" autocomplete="off"
                   type="search"></p>
        <?php echo script("qs('#filter-field').oninput = tablesFilterInput;");
    }
}
