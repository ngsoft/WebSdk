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
    protected static $passwordLess = [
        "sqlite" => "ADMINER_SQLITE_PASSWORD",
        "sqlite2" => "ADMINER_SQLITE2_PASSWORD",
        "simpledb" => "ADMINER_SIMPLEDB_PASSWORD",
    ];


    /** @access protected */
    protected $servers = [];
    protected $dynamic = true;
    protected $drivers = [];

    protected $defaultDriver = null;
    protected $currentDriver = "";
    protected $save = false;
    protected $sessionKey = "adminer-server-list";

    protected $passwordHashes = [];

    /** Set supported servers
     * @param array $servers array($description => array("server" => "127.0.0.1", "driver" => "server|pgsql|sqlite|..."))
     * @param string|false $save
     * @param string|string[] $defaultDriver
     */
    public function __construct($servers = [], $defaultDriver = "server", $save = false, $dynamic = true)
    {

        /**
         * Master password SQLite db
         */
        foreach (static::$passwordLess as $passwordLessDriver => $passwordLessKey) {
            if (!empty($_ENV[$passwordLessKey])) {
                $this->passwordHashes[$passwordLessDriver] = password_hash($_ENV[$passwordLessKey], PASSWORD_DEFAULT);
            }
        }

        $this->dynamic = $dynamic;
        $this->save = $save;
        $this->drivers = self::$driverList;
        if (is_array($defaultDriver)) {
            $this->drivers = [];
            foreach ($defaultDriver as $driver) {
                if (strtolower($driver) === "mysql") {
                    $driver = "server";
                }
                if (isset(self::$driverList[$driver])) {
                    $this->drivers[$driver] = self::$driverList[$driver];
                    if (isset($_GET[$driver])) {
                        $this->currentDriver = $driver;
                    }
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
        } elseif (!empty($_SESSION[$this->sessionKey])) {
            $this->servers = $_SESSION[$this->sessionKey];
        } elseif (empty($servers) && !$dynamic) {
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
            $address = "";
            if (!empty($_POST['custom-server']) && !empty($_POST['custom-server-address'])) {
                $_POST["auth"]["server"] = $_POST['custom-server'];
                $address = $_POST['custom-server-address'];
            }

            if (empty($_POST["auth"]["driver"])) {
                $_POST["auth"]["driver"] = $defaultDriver;
            }
            $key = $_POST["auth"]["server"];
            if (empty($address)) {
                $address = $key;
            }

            if (!empty($key)) {
                if (!isset($this->servers[$key])) {
                    $this->servers[$key] = [
                        "driver" => $_POST["auth"]["driver"],
                        "server" => $address,
                    ];
                    $_SESSION[$this->sessionKey] = $this->servers;
                    if (is_string($save)) {
                        @file_put_contents($save, json_encode($this->servers));
                    }
                }

                $this->currentDriver = $_POST["auth"]["driver"] = $this->servers[$key]["driver"];
            }
        }
    }

    public function credentials()
    {

        $user = "";
        if (!empty($_GET["username"])) {
            $user = $_GET["username"];
        }
        return array($this->servers[SERVER]["server"], $user, get_password());
    }

    public function login($login, $password)
    {
        
        if (!isset($this->servers[SERVER])) {
            return false;
        }

        $driver = $this->servers[SERVER]["driver"];
        if (!empty($this->passwordHashes[$driver])) {
            return password_verify($password, $this->passwordHashes[$driver]);
        }


        // password-less drivers
        if (empty($password) || empty($login)) {
            return isset(self::$passwordLess[$driver]);
        }

        return null;
    }

    /**
     * @param ?string $driver
     * @return array|bool
     */
    protected function canHidePassword($driver = null)
    {
        $values = [];
        foreach (array_keys($this->drivers) as $key) {

            if (!isset(static::$passwordLess[$key])) {
                $values[$key] = false;
                continue;
            }

            $values[$key] = empty($this->passwordHashes[$key]);
        }
        if (null === $driver) {
            return $values;
        }

        if (!isset($values[$driver])) {
            return false;
        }

        return $values[$driver];
    }


    protected function getAvailableDrivers()
    {


        static $drivers = null;
        if (!$drivers) {
            $drivers = [];
            foreach ($GLOBALS as $var) {
                if (is_array($var) && $var["server"] === "MySQL" && !isset($var["username"])) {
                    $drivers = $var;
                    break;
                }
            }
        }
        return $drivers;
    }


    /** @noinspection HtmlUnknownAttribute */
    public function loginFormField($name, $heading, $value)
    {

        if ($name == 'username') {


            if (isset(static::$passwordLess[$this->currentDriver ?: $this->defaultDriver])) {
                $heading = str_replace("<tr>", '<tr id="username-form" style="display:none;">', $heading);
                $value = preg_replace('#value="[^"]+"#', 'value=""', $value);
            }
            $heading = str_replace(
                "<tr>",
                '<tr id="username-form">',
                $heading
            );

            // fix error max_input_var not set correctly
            if (isset($_SESSION["token"])) {
                $value .= sprintf('<input type="hidden" name="token" value="%s">', $_SESSION["token"]);
            }


        }

        if ($name == 'password') {
            if ($this->canHidePassword($this->currentDriver ?: $this->defaultDriver)) {
                $heading = str_replace(
                    "<tr>",
                    '<tr id="password-form" style="display:none;">',
                    $heading
                );
                $value = preg_replace('#value="[^"]+"#', 'value=""', $value);
            }

            $heading = str_replace(
                "<tr>",
                '<tr id="password-form">',
                $heading
            );
        }

        if ($name == 'driver') {


            if ($this->dynamic) {

                if (count($this->drivers) > 1) {
                    if (empty(SERVER)) {
                        $this->currentDriver = current($this->servers)["driver"];
                    }

                    if (count($this->servers) > 1) {
                        $heading = str_replace(
                            "<tr>",
                            '<tr id="driver-select-form" style="display:none;">',
                            $heading
                        );
                    }

                    $heading = str_replace(
                        "<tr>",
                        '<tr id="driver-select-form">',
                        $heading
                    );
                    $availableDrivers = $this->getAvailableDrivers();


                    $html = '<select id="driver-select" style="width: 100%;">';
                    $html .= '<option value="">Select a Driver</option>';
                    foreach (array_keys($availableDrivers) as $value) {
                        if (empty($value)) {
                            continue;
                        }
                        if (!isset($this->drivers[$value])) {
                            continue;
                        }
                        $label = self::$driverList[$value];
                        $selected = $value === ($this->currentDriver) ? "selected" : "";
                        $html .= sprintf('<option %s value="%s" >%s</option>', $selected, $value, $label);
                    }
                    $html .= '</select>';
                    $html .= sprintf('<input type="hidden" name="auth[driver]" value="%s">', $this->currentDriver);

                    ob_start(); ?>
                    <script <?= nonce() ?> type="text/javascript">
                        const
                            canHideUser = <?= json_encode(array_keys(static::$passwordLess)) ?>,
                            canHidePass = <?= json_encode($this->canHidePassword()) ?>,
                            /** @type HTMLInputElement */
                            inputValue = document.querySelector('[name="auth[driver]"]');


                        function updateAuthForm() {
                            const
                                userForm = document.getElementById('username-form'),
                                passForm = document.getElementById('password-form'),
                                /** @type HTMLSelectElement*/
                                selectDriver = document.getElementById('driver-select');
                            inputValue.value = selectDriver.value;
                            if (userForm instanceof Element && passForm instanceof Element) {
                                if (canHideUser.includes(inputValue.value)) {
                                    userForm.style.display = "none";
                                    userForm.querySelector("input").value = "";
                                    if (canHidePass[inputValue.value]) {
                                        passForm.style.display = "none";
                                        passForm.querySelector("input").value = "";
                                    }
                                    return;
                                }
                                userForm.style.display = null;
                                passForm.style.display = null;
                            }
                        }

                        addEventListener("DOMContentLoaded", () => {

                            const /** @type HTMLSelectElement*/ driverSelect = document.getElementById('driver-select');
                            driverSelect.onchange = updateAuthForm;
                            driverSelect.form.onsubmit = e => {
                                if (!driverSelect.value) {
                                    e.preventDefault();
                                    alert("Please select a driver first");
                                }
                            };

                        });
                    </script>
                    <?php $html .= ob_get_clean();

                    return $heading . $html;
                }
                return sprintf('<input type="hidden" name="auth[driver]" value="%s">', $this->defaultDriver);
            }
            return '<input type="hidden" name="auth[driver]" value="">';
        }
        if ($name == 'server') {
            if ($this->dynamic && count($this->servers)) {
                $html = '<input type="text" value="" name="custom-server" style="display: none;" placeholder="localhost" title="Server name">';
                $html .= sprintf('<input type="%s" value="" name="custom-server-address" style="display: none;" placeholder="127.0.0.1" title="Server address">', $this->save ? "text" : "hidden");
                $html .= '<select name="auth[server]" style="width: 100%;">';
                $html .= optionlist(array_keys($this->servers), SERVER);
                $html .= '<option value="" id="addCustomServer">Add a Server</option>';
                $html .= "</select>";
            } elseif ($this->dynamic) {
                $html = '<input style="display: block;" type="text" value="" name="custom-server"  placeholder="localhost" title="Server name" >';
                $html .= sprintf('<input style="display: block;" type="%s" value="" name="custom-server-address" placeholder="127.0.0.1" title="Server address">', $this->save ? "text" : "hidden");
            } else {
                $html = '<select name="auth[server]" style="width: 100%;">';
                $html .= optionlist(array_keys($this->servers), SERVER);
                $html .= "</select>";
            }


            ob_start();
            ?>
            <script <?= nonce() ?>
                    type="text/javascript">
                document.querySelector(`[name="auth[driver]"]`).onchange = () => {
                };
            </script>
            <?php if ($this->dynamic): ?>
                <script <?= nonce() ?> type="text/javascript">
                    const
                        selectDriver = document.getElementById('driver-select'),
                        servers = <?= json_encode($this->servers, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>,
                        driverForm = document.getElementById('driver-select-form'),
                        inputName = document.querySelector('[name="custom-server"]'),
                        inputAddress = document.querySelector('[name="custom-server-address"]'),
                        sync = () => {
                            inputAddress.value = inputName.value;
                        };


                    if (inputName) {
                        inputName.addEventListener('input', sync);
                        inputAddress.addEventListener("input", () => {
                            inputName.removeEventListener('input', sync);
                        }, {
                            once: true
                        });
                    }


                    document.querySelectorAll('[name="auth[server]"]').forEach(el => {
                        el.addEventListener('change', () => {

                            if (el.options[el.selectedIndex].id === 'addCustomServer') {
                                el.style.display = 'none';
                                if (driverForm instanceof Element) {
                                    driverForm.style.display = null;
                                }
                                [inputName, inputAddress].forEach(input => {
                                    input.setAttribute('required', '');
                                    input.style.display = "block";
                                });
                                return;
                            }
                            if (selectDriver) {
                                if (servers[el.value]) {
                                    selectDriver.value = servers[el.value]["driver"];
                                }
                                updateAuthForm();
                            }

                        })
                    });
                </script>
                <?php $html .= ob_get_clean();
            endif;

            return $heading . "$html\n";
        }


        return $heading . $value;
    }
}
