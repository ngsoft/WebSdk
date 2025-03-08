# WebSdk

## Que contient WebSdk ?

- [Node version manager for windows](https://github.com/coreybutler/nvm-windows)

- [nginx  for  Windows](http://nginx.org/en/docs/windows.html)

- [MariaDB.](https://mariadb.org/documentation/)

- [Php](https://www.php.net/)    5.5/5.6/7.4/8.1/8.2/8.3

- [PEAR](https://pear.php.net/) est disponible pour toutes les versions de php

- [PhpMyadmin](https://www.phpmyadmin.net/) a dézipper

- [Adminer](https://www.adminer.org/) avec themes

- [Composer](https://getcomposer.org/)

- [Phan](https://github.com/phan/phan)

- [Python](https://www.python.org/downloads/)

- [Go](https://go.dev/dl/)
  
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

- Nvm + NodeJS (dernière version) + NPM

- Python3 (pip + virtualenv)

- Go (Téléchargement du zip et extraction)

- Création d'une base de donnée MariaDB

- Téléchargement de dernier certificats
  openssl/curl [curl - Extract CA Certs from Mozilla](https://curl.se/docs/caextract.html)

- Composer (php 7.4 8.1 8.2 8.3), Composer LTS (php 5.5 5.6)

Il vous est recommandé de redémarrer votre PC après cette opération.

## Les commandes disponibles

Plusieurs versions de Php sont disponibles, donc pour exécuter une version spécifique de Php vous pouvez exécuter dans
le terminal:

```shell
php5.5 -v
php5.6 -v
php7.4 -v
php8.1 -v
php8.2 -v
php8.3 -v
```

La version de php par défaut est la 8.1 car les extensions pecl ne sont pas encore disponibles pour la 8.2 sur Windows

```shell
php -v
```

Php 8.2 est utilisée avec Nginx en FastCGI et est configurée pour utiliser Opcache
et [Just-in-time compilation](https://en.wikipedia.org/wiki/Just-in-time_compilation)

Les autres commandes disponibles sont :

```shell
pear # exécuté dans un environement php5.6
pecl # exécuté dans un environement php5.6
node -v
npm -v
```

Composer à aussi des commandes liées à la version de php

```shell
composer # va exécuter composer8.1
composer5.5 # va exécuter le version LTS de composer (php5.5)
composer5.6 # va exécuter le version LTS de composer (php5.6)
composer7.4 # va exécuter composer dans un environnement 7.4
composer8.1
composer8.2
composer8.3
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
```

## Win32 API

l'extension `win32std` à été compilée et intégrée aux versions php `8.2`, `8.3` et `8.4`
En attandant que des stubs soient générés, une documentation est disponible à l'adresse suivante: [win32std - Windows binding for PHP](http://wildphp.free.fr/wiki/doku.php?id=win32std:index)


## Les commandes du SDK:

Ce sdk fournit des commandes pour démarrer et arrêter les services :

```shell
websdk-start
```

Cette commande va démarrer les services `MariaDB`, `Nginx avec PHP8.2` et lancer le navigateur sur `PhpMyAdmin`

Les identifiants de la base de donnée sont :

`mysql://root:toor@localhost:3306/dbname`

|     **user** | `root` |
| -----------: | ------ |
| **password** | `toor` |

Les applications web installées sont:

- [Adminer](http://localhost/adminer)

- [PhpMyAdmin](http://localhost/phpmyadmin)

```shell
websdk-stop
```

Cette commande va arrêter tous les services démarrés par `websdk-start`

Une application a été développée en Python pour faciliter le démarrage du SDK (SysTray App)




