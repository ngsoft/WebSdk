<?php

/** Display constant list of servers in login form
 * @link https://www.adminer.org/plugins/#use
 * @author Jakub Vrana, https://www.vrana.cz/
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerLoginServers
{
    protected static $driverList = [
        "server" => "MySQL",
        "sqlite" => "SQLite 3",
        "sqlite2" => "SQLite 2",
        "pgsql" => "PostgreSQL",
        "oracle" => "Oracle",
        "mssql" => "MS SQL",
        "firebird" => "Firebird",
        "simpledb" => "SimpleDB",
        "mongo" => "MongoDB",
        "elastic" => "Elasticsearch",
        "elastic7" => "Elasticsearch 7",
    ];

    /** @access protected */
    protected $servers = [];
    protected $dynamic = true;
    protected $drivers = [];

    protected $defaultDriver;

    /** Set supported servers
     * @param array $servers array($description => array("server" => "127.0.0.1", "driver" => "server|pgsql|sqlite|..."))
     * @param string|false $save
     * @param string|string[] $defaultDriver
     */
    function __construct($servers = [], $defaultDriver = "server", $save = false, $dynamic = true)
    {

        $this->dynamic = $dynamic;

        $this->drivers = self::$driverList;
        if (is_array($defaultDriver)) {
            $this->drivers = [];
            foreach ($defaultDriver as $driver) {
                if (strtolower($driver) === "mysql") {
                    $driver = "server";
                }
                if (isset(self::$driverList[$driver])) {
                    $this->drivers[$driver] = self::$driverList[$driver];
                }
            }

            $defaultDriver = $defaultDriver[0];
        }

        if (strtolower($defaultDriver) === "mysql") {
            $defaultDriver = "server";
        }

        $this->defaultDriver = $defaultDriver;

        if (is_string($save) && is_file($save)) {
            $saved = @file_get_contents($save);
            if ($saved) {
                $saved = @json_decode($saved, true);
                if (is_array($saved)) {
                    $this->servers = $saved;
                }
            }
        } elseif (empty($servers)) {
            $this->servers = [
                'localhost' => ['driver' => $defaultDriver, 'server' => '127.0.0.1'],
            ];
        }

        foreach ($servers as $i => $item) {

            $name = "";
            $ip = "";
            $driver = $defaultDriver;

            if (is_string($i)) {
                $name = $i;
            }

            if (is_string($item)) {
                $ip = $item;
            } elseif (is_array($item)) {
                if (isset($item['server'])) {
                    $ip = $item['server'];
                }
                if (isset($item['name'])) {
                    $name = $item['name'];
                }
                if (isset($item['driver'])) {
                    $driver = $item['driver'];
                }
                foreach ($item as $k => $v) {
                    if (is_int($k)) {
                        if (!empty($ip)) {
                            $name = $ip;
                        }
                        $ip = $v;
                    }
                }
            }
            if (!empty($ip) && empty($name)) {
                $name = $ip;
            }
            if ($name && $ip) {
                $this->servers[$name] = ["server" => $ip, "driver" => $driver];
            }
        }

        if (isset($_POST["auth"])) {
            if (!empty($_POST['custom-server'])) {
                $_POST["auth"]["server"] = $_POST['custom-server'];
            }

            if (empty($_POST["auth"]["driver"])) {
                $_POST["auth"]["driver"] = $defaultDriver;
            }
            $key = $_POST["auth"]["server"];

            if (!empty($key)) {
                if (!isset($this->servers[$key]) && is_string($save)) {
                    $this->servers[$key] = [
                        "driver" => $_POST["auth"]["driver"],
                        "server" => $key,
                    ];
                    @file_put_contents($save, json_encode($this->servers));
                }
                $_POST["auth"]["driver"] = $this->servers[$key]["driver"];
            }
        }
    }

    function credentials()
    {
        return array($this->servers[SERVER]["server"], $_GET["username"], get_password());
    }

    function login($login, $password)
    {
        return isset($this->servers[SERVER]);
    }


    /** @noinspection HtmlUnknownAttribute */
    function loginFormField($name, $heading, $value)
    {
        global $ic;


        if ($name == 'driver') {
            if ($this->dynamic) {

                if (count($this->drivers) > 1) {
                    $availableDrivers = $ic;
                    $html = '<select name="auth[driver]" style="width: 100%;">';
                    $html .= '<option value="">Select a Driver</option>';
                    foreach (array_keys($availableDrivers) as $value) {
                        if (empty($value)) {
                            continue;
                        }
                        if (!isset($this->drivers[$value])) {
                            continue;
                        }
                        $label = self::$driverList[$value];
                        $selected = $value === $this->defaultDriver ? "selected" : "";
                        $html .= sprintf('<option %s value="%s" >%s</option>', $selected, $value, $label);
                    }
                    $html .= '</select>';
                    return $heading . $html;
                }
                return sprintf('<input type="hidden" name="auth[driver]" value="%s">', key($this->drivers));
            }
            return '<input type="hidden" name="auth[driver]" value="">';
        }
        if ($name == 'server') {
            if ($this->dynamic) {
                $html = '<input type="text" value="" name="custom-server" style="display: none;" placeholder="localhost">';
                $html .= '<select name="auth[server]" style="width: 100%;">';
                $html .= optionlist(array_keys($this->servers), SERVER);
                $html .= '<option value="" id="addCustomServer">Add a Server</option>';
            } else {
                $html = '<select name="auth[server]">';
                $html .= optionlist(array_keys($this->servers), SERVER);
            }

            $html .= "</select>";

            ob_start(); ?>
            <script <?= nonce() ?> type="text/javascript">
                document.querySelector(`[name="auth[driver]"]`).onchange = () => {
                };
                document.querySelectorAll('[name="auth[server]"]').forEach(el => {
                    el.addEventListener('change', e => {
                        if (el.options[el.selectedIndex].id === 'addCustomServer') {
                            el.previousElementSibling.setAttribute('required', '');
                            el.previousElementSibling.style.display = null;
                            el.style.display = 'none';
                        }
                    })
                });
            </script>
            <?php $html .= ob_get_clean();

            return $heading . "$html\n";
        }


        return $heading . $value;
    }
}
