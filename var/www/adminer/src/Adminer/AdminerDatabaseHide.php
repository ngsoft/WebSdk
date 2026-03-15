<?php

namespace Adminer;

/** Hide some databases from the interface - just to improve design, not a security plugin.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerDatabaseHide
{
    protected $disabled;

    protected $translations = [
        'cs' => ['' => 'Skryje některé databáze z rozhraní – pouze vylepší vzhled, nikoliv bezpečnost'],
        'de' => ['' => 'Verstecken Sie einige Datenbanken vor der Benutzeroberfläche – nur um das Design zu verbessern, verbessert nicht die Sicherheit'],
        'pl' => ['' => 'Ukryj niektóre bazy danych w interfejsie – tylko po to, aby ulepszyć motyw, a nie wtyczkę zabezpieczającą'],
        'ro' => ['' => 'Ascundeți unele baze de date din interfață - doar pentru a îmbunătăți designul, nu un plugin de securitate'],
        'ja' => ['' => '一部データベースを UI 上で表示禁止 (デザイン的な効果のみでセキュリティ的には効果なし)'],
    ];

    /**
     * @param list<string> $disabled case insensitive database names in values
     */
    public function __construct(array $disabled)
    {
        $this->disabled = array_map('strtolower', $disabled);
    }

    public function databases($flush = true)
    {
        $return = [];

        foreach (get_databases($flush) as $db)
        {
            if ( ! in_array(strtolower($db), $this->disabled))
            {
                $return[] = $db;
            }
        }
        return $return;
    }
}
