<?php

namespace Adminer;

/**
 * Use Bootstrap Select component
 */
class AdminerBootstrapSelect
{

    public static $enabled = true;

    protected $dark;
    protected $fix;
    protected $select;

    protected $lang;

    protected $theme = "";

    public function __construct($theme = "", $dark = false, $fix = false, $select = true, $lang = true)
    {
        $this->dark = $dark;
        $this->theme = $theme;
        $this->fix = $fix;
        $this->select = $select;
        $this->lang = $lang;
    }


    public function head()
    {
        if (!self::$enabled) {
            return;
        } ?>
        <link rel="stylesheet" <?= nonce() ?> type="text/css" href="./static/select.css">
        <script <?= nonce() ?> type="module">
            <?php if ($this->select) : ?>
                document.querySelectorAll('select').forEach(s => {
                    if (s.closest("#lang")) {
                        return;
                    }
                    s.classList.add('form-select', 'form-select-sm')
                });
            <?php endif; ?>
            <?php if ($this->dark) : ?>
                document.documentElement.setAttribute("data-bs-theme", "dark");
            <?php endif; ?>
            <?php if (!empty($this->theme)): ?>
                document.documentElement.dataset.adminerTheme = `<?= $this->theme ?>`;
            <?php endif;
            if ($this->fix): ?>
                document.documentElement.dataset.fix = `true`;
            <?php endif; ?>
            document.documentElement.dataset.lang = `<?= json_encode($this->lang) ?>`;
        </script>
<?php
    }
}
