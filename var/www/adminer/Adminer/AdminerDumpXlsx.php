<?php

namespace Adminer;

/**
 * Download a select result as XLSX format.
 *
 * Install to Adminer on http://www.adminer.org/plugins/
 * @author Tom Higuchi, http://tom-gs.com/
 */
class AdminerDumpXlsx
{
    /**
     * @var  string
     */
    private $pathToSheetJs = 'xlsx/xlsx.full.min.js';

    /**
     * @var string
     */
    private $pathToFileSaverJs = 'xlsx/FileSaver.min.js';

    /**
     * @var string
     */
    private $pathToDumpXlsxJs = 'xlsx/dump.xlsx.js';


    /**
     * @param string $path
     * @return string
     */
    private function addNonce($path)
    {
        if (strpos('?', $path)) {
            return $path .= '&nonce=' . get_nonce();
        }
        return $path .= '?nonce=' . get_nonce();
    }

    public function head()
    {
        echo script_src($this->addNonce(asset($this->pathToSheetJs)));
        echo script_src($this->addNonce(asset($this->pathToFileSaverJs)));
        echo script_src($this->addNonce(asset($this->pathToDumpXlsxJs)));
    }
}
