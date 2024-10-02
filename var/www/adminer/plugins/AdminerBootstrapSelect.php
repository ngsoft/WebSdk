<?php

class AdminerBootstrapSelect
{


    protected $dark;

    public function __construct($dark = false)
    {
        $this->dark = $dark;
    }


    public function head()
    {
        ?>
        <link rel="stylesheet" <?= nonce() ?> type="text/css" href="./static/select.css">
        <script <?= nonce() ?> type="module">
            document.querySelectorAll('select').forEach(s => {
                s.classList.add('form-select', 'form-select-sm')
            });
            <?php if($this->dark) : ?>
            document.documentElement.setAttribute("data-bs-theme", "dark");
            <?php endif; ?>
        </script>
        <?php
    }
}

