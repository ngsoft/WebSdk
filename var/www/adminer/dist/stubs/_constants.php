<?php
/** @noinspection ALL */

namespace Adminer;

/** @var string Adminer version */
const VERSION = '6.2.0';
/** @var bool whether the connection is over HTTPS (also true behind a TLS-terminating reverse proxy) */
define('Adminer\HTTPS', false);
/** @var string original session name from php.ini, read before Adminer renames the session */
define('Adminer\SESSION_NAME', '');
/** @var string JUSH syntax-highlighting language key of the current driver */
define('Adminer\JUSH', '');
/** @var string selected server, '' means the default server */
define('Adminer\SERVER', '');
/** @var string selected database */
define('Adminer\DB', '');
/** @var string base URL of the current request with the common query-string parameters */
define('Adminer\ME', '');
/** @var string current language code, e.g. 'en' */
define('Adminer\LANG', '');
