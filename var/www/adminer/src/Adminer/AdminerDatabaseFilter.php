<?php

namespace Adminer;

/**
 * Use tom-select filter databases
 */
class AdminerDatabaseFilter extends TomSelectAdapter
{


    function head()
    {

        $this->loadBase();
        $this->loadTheme('custom'); ?>

        <style <?= nonce() ?>>
            #menu #dbs[data-filter="true"] {
                overflow: initial !important;
                padding: 0 !important;

                label {
                    display: flex;
                    justify-content: flex-start;
                    align-items: center;
                    padding: 8px 0;
                    margin: 0 6px;
                }

                .ts-wrapper {
                    width: 100%;
                    margin-left: 4px;
                }
            }
        </style>
        <script <?= nonce() ?> type="module">
            const select = qs(`#dbs select[name="db"]`);
            if (select) {
                select.classList.remove('form-select', 'form-select-sm');
                select.previousSibling.remove();
                select.closest(`#dbs`).setAttribute('data-filter', 'true');
            }

        </script>
        <?php
        $this->attachSelect('#dbs select[name="db"]', [
            'placeholder' => 'Database',
            'maxItems' => 1,
            'maxOptions' => null,
            'plugins' => ['change_listener']
        ]);
    }
}