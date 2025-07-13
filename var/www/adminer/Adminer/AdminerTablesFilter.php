<?php


namespace Adminer;
/** Filter names in tables list
 * @link https://www.adminer.org/plugins/#use
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerTablesFilter
{
    function tablesPrint($tables)
    {
        ?>
        <script<?php echo nonce(); ?>>
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
        <style>
            #tables {
                position: relative;
                top: 0;
                margin-left: 0;
                margin-right: 0;
                max-width: 100%;
            }
        </style>
        <p style="padding: 4px 15px; display: flex; justify-content: center;" class="jsonly">
            <input placeholder="Search table" value="" style="width: 90%;" id="filter-field" autocomplete="off"
                   type="search">
        <?php echo script("qs('#filter-field').oninput = tablesFilterInput;");
    }

    protected $translations = array(
        'cs' => array('' => 'Filtruje názvy v seznamu tabulek'),
        'de' => array('' => 'Filtern Sie Namen in der Tabellenliste'),
        'pl' => array('' => 'Filtruj nazwy na liście tabel'),
        'ro' => array('' => 'Nume de filtre în lista de tabele'),
        'ja' => array('' => 'テーブル一覧をテーブル名でフィルタリング'),
    );
}
