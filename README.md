# WebSdk

Environnement de développement web complet pour Windows, installable à la racine de `C:\` et pilotable
depuis une application de barre des tâches (SysTray).

## Que contient WebSdk ?

Serveurs et bases de données :

- [Apache httpd](https://httpd.apache.org/docs/2.4/) 2.4 (Apache Lounge, HTTPS activé)

- [nginx pour Windows](http://nginx.org/en/docs/windows.html) 1.27 (PHP en FastCGI)

- [MariaDB](https://mariadb.org/documentation/) 12.2

- [PostgreSQL](https://www.postgresql.org/docs/) 17 / 18

- [Redis](https://redis.io/docs/latest/) 8 (service Windows, port 6379)

Langages et outils :

- [Php](https://www.php.net/) 5.6 / 7.4 / 8.1 / 8.2 / 8.3 / 8.4 / 8.5

- [PEAR / PECL](https://pear.php.net/) (exécutés dans un environnement php5.6)

- [Composer](https://getcomposer.org/) (une commande par version de PHP)

- [Phan](https://github.com/phan/phan), [PHP-CS-Fixer](https://cs.symfony.com/)
  et [Rector](https://getrector.com/) pour l'analyse et la modernisation du code

- [Node version manager for windows](https://github.com/coreybutler/nvm-windows) + NodeJS 24 + NPM

- [Python](https://www.python.org/downloads/) 3.14 installé via [uv](https://docs.astral.sh/uv/)

- [Go](https://go.dev/dl/) 1.25 installé via [gvm](https://github.com/andrewkroh/gvm)

Applications web :

- [Adminer](https://www.adminer.org/) avec thèmes (installé dans `var/www/adminer`)

- [phpMyAdmin](https://www.phpmyadmin.net/) (optionnel, à déposer dans `var/www/phpMyAdmin`)

## Prérequis

Si MySQL est déjà installé, veuillez exporter les bases de données que vous voulez conserver et désinstaller le
programme

Si Php est déjà installé, veuillez l'enlever de vos variables d'environment PATH

Si vous n'avez pas installé tous les C++ Redistributable de 2005 à 2023 dans l'ordre Veuillez les désinstaller et
exécuter le fichier de commande en adminstrateur
de [celui ci](https://www.techpowerup.com/download/visual-c-redistributable-runtime-package-all-in-one/)

Si NodeJs est déjà installé, veuillez :

- exporter la liste des paquets globaux que vous avez installé :

```shell
npm -g list > my-npm-packages.txt
```

- Désinstaller NodeJs et enlever les variables d'environement correspondantes.

## Installation

Veuillez vous procurer une copie de cette repo:

- Soit télécharger le zip de cette repo

- Soit exécuter cette commande:

```shell
git clone https://github.com/ngsoft/WebSdk.git --depth 1
```

Déplacer le répertoire WebSdk à la racine de `C:\` et ensuite, installez l'environnement de développement en exécutant en tant qu'administrateur:

```batch
C:\WebSdk\setup.bat
```

Cela va installer:

- Les variables d'environnement PATH pour tous les exécutables

- Nvm + NodeJS + NPM

- Python 3 via uv (pip + virtualenv + pyinstaller)

- Go via gvm (+ `minica` pour la génération des certificats)

- Création d'une base de donnée MariaDB

- Téléchargement des derniers certificats
  openssl/curl [curl - Extract CA Certs from Mozilla](https://curl.se/docs/caextract.html)

- Composer (php >= 7.4), Composer LTS (php 5.6)

- Génération et installation d'un certificat racine de développement (`lib/ca`) pour servir le SDK en `https://`

- L'application de barre des tâches `websdk-tray` au démarrage de Windows, et son raccourci dans le menu Démarrer

Il vous est recommandé de redémarrer votre PC après cette opération.

## Les commandes disponibles

Plusieurs versions de Php sont disponibles, donc pour exécuter une version spécifique de Php vous pouvez exécuter dans
le terminal:

```shell
php5.6 -v
php7.4 -v
php8.1 -v
php8.2 -v
php8.3 -v
php8.4 -v
php8.5 -v
```

La version de php par défaut est la 8.2 car c'est celle qui dispose du plus grand nombre d'extensions pecl compilées
pour Windows

```shell
php -v
```

Les autres commandes disponibles sont :

```shell
pear # exécuté dans un environement php5.6
pecl # exécuté dans un environement php5.6
node -v
npm -v
py -V # python fourni par uv
uv --version
go version
```

Composer à aussi des commandes liées à la version de php

```shell
composer # va exécuter composer avec la version de php par défaut
composer5.6 # va exécuter la version LTS de composer (php5.6)
composer7.4 # va exécuter composer dans un environnement 7.4
composer8.1
composer8.2
composer8.3
composer8.4
composer8.5
```

Vous pouvez aussi charger les librairies installées en utilisant `composer global require` :

```php
<?php

// will load etc/composer-lts/vendor/autoload.php autoloader for php < 7.0
// and etc/composer/vendor/autoload.php for php >=7.0

require_once 'composer_global.php';

```

Phan est aussi fourni pour faire une analyse du code :

```shell
phan
phan7.4
phan8.1
phan8.2
phan8.3
phan8.4
```

PHP-CS-Fixer et Rector sont installés à la demande (au premier lancement) dans `lib/` :

```shell
php-cs-fixer setup   # copie .php-cs-fixer.dist.php dans le projet courant
php-cs-fixer update  # met à jour l'outil
php-cs-fixer fix

rector setup         # copie rector.php dans le projet courant
rector update
rector process
```

Quelques raccourcis pour les projets PHP et front-end :

```shell
artisan       # php artisan (projet Laravel)
laravel       # laravel installer, ou artisan si un projet est détecté
console       # php bin/console (projet Symfony)
biome         # npx @biomejs/biome
svelte        # npx sv
jsrepo        # npx jsrepo
shadcn-svelte # npx shadcn-svelte@latest
adminer       # ouvre Adminer dans le navigateur
pma           # ouvre phpMyAdmin (s'il est installé)
7zcat         # affiche le contenu d'une archive sur la sortie standard
e / e.        # ouvre l'explorateur de fichiers
```

## Win32 API

l'extension `win32std` à été compilée et intégrée aux versions php `8.2`, `8.3` et `8.4`
En attandant que des stubs soient générés, une documentation est disponible à l'adresse suivante: [win32std - Windows binding for PHP](http://wildphp.free.fr/wiki/doku.php?id=win32std:index)

## Démarrer et arrêter les services

Une application développée en Python (SysTray App) permet de piloter le SDK : `websdk-tray.exe` est lancé au démarrage
de Windows et son menu permet de démarrer/arrêter les services. Elle est configurée
par `etc/websdk-tray.json` (copié depuis `etc/websdk-tray-dist.json` lors de l'installation).

Le menu propose notamment :

- **WebSdk [apache|mariadb]** : Apache + MariaDB (PHP en module ou en FastCGI selon la configuration Apache)

- **WebSdk [nginx|php|mariadb]** : nginx + PHP FastCGI (port 9802) + MariaDB

- **WebSdk [apache|postgres]** : Apache + PostgreSQL

- **Redis** et **PostgreSQL** : démarrage/arrêt indépendants

- **Console MariaDB** / **Console PostgreSql**

- **Configurer Apache** (ouvre `lib/httpd/conf/custom`) et **Changer nginx PHP version** (ouvre `etc/php-cgi.bat`)

- **Adminer**, **phpMyAdmin** et **informations PHP**

Les mêmes actions sont disponibles en ligne de commande dans `lib/sdk/scripts` (élévation UAC automatique) :

```batch
lib\sdk\scripts\start-httpd.bat     & lib\sdk\scripts\stop-httpd.bat
lib\sdk\scripts\start-nginx.bat     & lib\sdk\scripts\stop-nginx.bat
lib\sdk\scripts\start-cgi.bat       & lib\sdk\scripts\stop-cgi.bat
lib\sdk\scripts\start-mariadb.bat   & lib\sdk\scripts\stop-mariadb.bat
lib\sdk\scripts\start-pg.bat        & lib\sdk\scripts\stop-pg.bat
lib\sdk\scripts\start-redis.bat     & lib\sdk\scripts\stop-redis.bat
```

Apache et Redis sont installés en tant que services Windows (`httpd`, `Redis`) démarrés à la demande.

## Accès aux bases de données

MariaDB (port 3306) :

`mysql://root:toor@127.0.0.1:3306/dbname`

|     **user** | `root` |
| -----------: | ------ |
| **password** | `toor` |

PostgreSQL (port 5432, utilisateur `postgres`, base `postgres`) : voir `lib/pg/env.bat`

Redis : `redis://root:toor@127.0.0.1:6379`

|     **user** | `root` |
| -----------: | ------ |
| **password** | `toor` |

Les applications web installées sont :

- [Adminer](https://localhost/adminer)

## Configuration

- **Racine web** : `var/www` (`DocumentRoot` par défaut d'Apache et de nginx)

- **Apache** : déposer vos fichiers de configuration dans `lib/httpd/conf/custom` (ils sont tous inclus).
  `000-php.conf` sert d'exemple : le copier en `111-php.conf` pour activer `mod_fcgid` et choisir la version de PHP
  (`Define PHPCGIVERSION "8.5"` en FastCGI, `Define PHPVERSION "8.5"` pour le module Apache).
  La variable `${SDKROOT}` pointe sur `C:\WebSdk`.

- **nginx** : la version de PHP utilisée par le FastCGI se règle dans `etc/php-cgi.bat` (`set "php_version=8.4"`),
  des options par version peuvent être ajoutées dans `etc/php-cgi/<version>.bat`.

- **PHP** : la configuration commune recommandée est documentée dans `lib/php/conf.md` (opcache, apcu, timezone,
  `curl.cainfo` / `openssl.cafile` pointant sur `lib/certs/cacert.pem`).

- **HTTPS** : les certificats sont générés par [minica](https://github.com/jsha/minica) dans `lib/ca`
  (`generate-certs.bat` pour `localhost` et le nom de la machine, `install-certs.bat` pour ajouter le certificat racine
  au magasin Windows). Le bundle CA de Mozilla est mis à jour automatiquement au démarrage d'Apache
  (`lib/certs/update.bat`).
