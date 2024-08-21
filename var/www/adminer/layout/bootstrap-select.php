<?php ob_start(); ?>
    <link rel="stylesheet" <?= nonce() ?> type="text/css" href="./static/select.css">
    <script <?= nonce() ?> type="module">
        document.querySelectorAll('select').forEach(s => {
            s.classList.add('form-select', 'form-select-sm')
        })
        // document.documentElement.setAttribute("data-bs-theme", "dark");
    </script>
<?php return ob_get_clean();
