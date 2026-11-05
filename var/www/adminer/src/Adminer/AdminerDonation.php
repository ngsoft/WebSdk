<?php

namespace Adminer;

/** Replace or hide the donation link in the top right corner.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerDonation extends Plugin
{
    protected $translations = [
        'cs' => ['' => 'Nahradí nebo skryje odkaz na příspěvek v pravém horním rohu'],
        'de' => ['' => 'Ersetzt oder verbirgt den Spenden-Link in der oberen rechten Ecke'], // Claude Opus 5.5
        'ja' => ['' => '右上の寄付リンクを置き換えるか非表示にする'], // Claude Opus 5.5
        'pl' => ['' => 'Zastąp lub ukryj link do wsparcia w prawym górnym rogu'], // Claude Opus 5.5
        'ro' => ['' => 'Înlocuiește sau ascunde linkul de donație din colțul din dreapta sus'], // Claude Opus 5.5
        'sk' => ['' => 'Nahradí alebo skryje odkaz na príspevok v pravom hornom rohu'], // Claude Opus 5.5
        'zh' => ['' => '替换或隐藏右上角的捐赠链接'], // Claude Opus 5.5
    ];
    private $html;

    /** @param string $html HTML code to print instead of the donation link, empty to hide it */
    public function __construct($html = '')
    {
        $this->html = $html;
    }

    public function donation()
    {
        return $this->html;
    }
}
