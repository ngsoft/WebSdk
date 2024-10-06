<?php

class AdminerBootstrapSelect
{

    public static $enabled = true;

    protected $dark;
    protected $fix;

    protected $theme = "";

    public function __construct($theme = "", $dark = false, $fix = false)
    {
        if (is_bool($theme)) {
            list($theme, $dark) = [$dark, $theme];
            if (!is_string($theme)) {
                $theme = "";
            }
        }
        $this->dark = $dark;
        $this->theme = $theme;
        $this->fix = $fix;

    }


    public function head()
    {
        if (!self::$enabled) {
            return;
        } ?>
        <link rel="stylesheet" <?= nonce() ?> type="text/css" href="./static/select.css">
        <script <?= nonce() ?> type="module">
            document.querySelectorAll('select').forEach(s => {
                s.classList.add('form-select', 'form-select-sm')
            });
            <?php if ($this->dark) : ?>
            document.documentElement.setAttribute("data-bs-theme", "dark");
            <?php endif; ?>
            <?php if(!empty($this->theme)): ?>
            document.documentElement.dataset.adminerTheme = `<?= $this->theme ?>`;
            <?php endif;
            if($this->fix): ?>
            document.documentElement.dataset.fix = `true`;
            <?php endif; ?>
        </script>
        <?php
    }
}
