<?php

namespace Adminer;

class AdminerDatabaseAutocomplete extends TomSelectAdapter
{


    function head()
    {

        $this->loadBase();
        $this->loadTheme('custom');


        ?>
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
        <style <?= nonce() ?>>
            #menu #dbs {
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
            qs(`#dbs select[name="db"]`)?.previousSibling.remove();
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