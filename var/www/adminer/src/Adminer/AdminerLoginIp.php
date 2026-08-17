<?php

namespace Adminer;

/** Check IP address and allow empty password.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerLoginIp
{
    public $ips             = [];

    public $forwarded_for   = [];

    protected $translations = [
        'cs' => ['' => 'Zkontroluje IP adresu a povolí prázdné heslo'],
        'de' => ['' => 'Überprüft die IP-Adresse und lässt ein leeres Passwort zu'],
        'pl' => ['' => 'Sprawdzaj adres IP i zezwakaj na puste hasło'],
        'ro' => ['' => 'Verificați adresa IP și permiteți parola goală'],
        'ja' => ['' => 'IP アドレスの確認、及び空パスワードの許可'],
        'hr' => ['' => 'Provjerava IP adresu i dopušta praznu lozinku'],
    ];

    /** Set allowed IP addresses.
     * @param array $ips           IP address prefixes
     * @param array $forwarded_for X-Forwarded-For prefixes if IP address matches, empty array means anything
     */
    public function __construct(array $ips, array $forwarded_for = [])
    {
        $this->ips           = $ips;
        $this->forwarded_for = $forwarded_for;
    }

    public function login($login, $password)
    {
        // no acl
        if (empty($this->ips))
        {
            return null;
        }

        // a proxy appends the client to X-Forwarded-For, the preceding values are sent by the client itself
        $forwarded_for = preg_replace('~.*, *~', '', strval($_SERVER['HTTP_X_FORWARDED_FOR'] ?: ''));

        // return null to use next plugin login
        if ($this->matchPrefix($_SERVER['REMOTE_ADDR'], $this->ips)
            && ( ! $this->forwarded_for || $this->matchPrefix($forwarded_for, $this->forwarded_for)))
        {
            return null;
        }
        // return false to block login
        return false;
    }

    /** Check if the value begins with one of the prefixes.
     * @param array $prefixes
     * @param mixed $value
     *
     * @return bool
     */
    private function matchPrefix($value, array $prefixes)
    {
        foreach ($prefixes as $prefix)
        {
            if (0 == strncasecmp(strval($value), $prefix, strlen($prefix)))
            {
                return true;
            }
        }
        return false;
    }
}
