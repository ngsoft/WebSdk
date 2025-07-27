<?php

namespace Adminer;

class TomSelectAdapter
{

    private static $loadedAssets = [];
    private $base_path = 'tom-select';
    private $assets = [
        'tom-select.complete.min.js',
        'tom-select.min.css'
    ];

    private $themes = [
        'default' => ['tom-select.default.min.css'],
        'bs4' => ['tom-select.bootstrap4.min.css'],
        'bs5' => ['tom-select.bootstrap5.min.css'],
        'custom' => ['tom-select.custom.css'],
    ];

    private function loadAssets(array $assets, $defer = false)
    {
        foreach ($assets as $file) {

            if (in_array($file, self::$loadedAssets)) {
                continue;
            }
            self::$loadedAssets[] = $file;
            $type = strtolower(preg_replace('#.+\.(\w+)$#', '$1', $file));
            $path = asset($this->base_path . '/' . $file);
            switch ($type) {
                case 'js':
                    echo script_src($path, $defer);
                    break;
                case 'css':
                    printf('<link rel="stylesheet" %s type="text/css" href="%s">', nonce(), $path);
                    break;
            }
        }
    }

    /**
     * @return void
     */
    protected function loadBase()
    {
        $this->loadAssets($this->assets);
    }

    /**
     * @param string $theme
     * @return void
     */
    protected function loadTheme($theme)
    {
        $theme = strtolower($theme);
        if (isset($this->themes[$theme])) {
            $this->loadAssets($this->themes[$theme]);
        }
    }


    protected function attachSelect($selector, array $options = [])
    {
        printf('<script type="module" %s>(()=>{%s})();</script>', nonce(), implode("\n", [
            sprintf("const select = qs(`%s`);", $selector),
            sprintf('select && tomSelect(select, %s);', empty($options) ? '{}' : json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)),
        ]));
    }

}