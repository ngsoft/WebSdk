<?php

/** Check IP address and allow empty password.
 * @see https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerLoginIp
{
    public $ips = [];

    public $forwarded_for = [];

    /** Set allowed IP addresses.
     * @param array $ips IP address prefixes
     * @param array $forwarded_for X-Forwarded-For prefixes if IP address matches, empty array means anything
     */
    public function __construct(array $ips, array $forwarded_for = [])
    {
        $this->ips = $ips;
        $this->forwarded_for = $forwarded_for;
    }

    public function login($login, $password)
    {
        // no acl
        if (empty($this->ips)) {
            return null;
        }
        // return null to use next plugin login
        foreach ($this->ips as $ip) {
            if (0 == strncasecmp($_SERVER['REMOTE_ADDR'], $ip, strlen($ip))) {
                if (!$this->forwarded_for) {
                    return null;
                }

                if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
                    foreach ($this->forwarded_for as $forwarded_for) {
                        if (0 == strncasecmp(preg_replace('~.*, *~', '', $_SERVER['HTTP_X_FORWARDED_FOR']), $forwarded_for, strlen($forwarded_for))) {
                            return null;
                        }
                    }
                }
            }
        }
        // return false to block login
        return false;
    }
}
