# Stubs

Stubs PHP (signatures seules, corps vidés) pour le code d'Adminer atteignable depuis le
point d'entrée [`adminer/index.php`](../adminer/index.php). Ils servent à l'autocomplétion
des IDE et aux outils d'analyse statique qui consomment Adminer (notamment le développement
de plugins), sans exécuter le code ni dépendre d'une connexion à une base.

Ce ne sont **pas** des fichiers à inclure à l'exécution avec Adminer : ils ne contiennent
aucune implémentation et redéclareraient les symboles réels.

## Compatibilité PHP 5.6

**Ces stubs doivent rester parseables en PHP 5.6.** Après génération depuis les sources
Adminer 6 (typées PHP 7+), retirer les types natifs incompatibles et les reporter en
PHPDoc :

| Retiré (PHP 7+) | Conservé (PHP 5.x) | Remplacé par |
|---|---|---|
| Scalaires `string` / `int` / `bool` / `float` | `array`, FQCN / classes | `@param` / `@return` / `@var` |
| Types de retour `: T` | — | `@return` |
| Nullable `?T` | classe/`array` avec `= null` (sans `?`) | `@param T\|null` |
| Propriétés typées `public string $x` | — | `@var` + `public $x` |

Script : `php dist/stubs/_strip_php7_types.php` (à relancer après toute régénération des
stubs typés). Ne pas y remettre de syntaxe PHP 7+ (`: void`, `?string`, typed properties,
etc.).

Chaque fichier stub doit commencer par `/** @noinspection ALL */` (PhpStorm) juste après
`<?php` — le script de strip le réinjecte s’il manque.

## Arborescence

La disposition suit **PSR-4** pour les classes et l'autoload `files` pour le reste, car
Adminer n'est pas une base de code entièrement PSR-4 (fonctions globales, constantes, et une
classe `Adminer\Driver` définie à l'identique dans chaque driver).

```
stubs/
  Adminer/            # PSR-4 : "Adminer\\" => "stubs/Adminer/", une classe par fichier
    Adminer.php  SqlDb.php  SqlDriver.php  PdoDb.php  PdoResult.php
    Plugins.php  Plugin.php  Password.php  Queries.php  Lang.php  TmpFile.php
  _functions/         # ~200 fonctions globales, par fichier source d'origine
    functions.php  html.php  editing.php  design.php  auth.php  decompress.php
    compress.php  xxtea.php  driver.php  lang.php  create.php  schema.php
    sql.php  table.php  type.php  user.php
  _constants.php      # VERSION + define() : HTTPS, SESSION_NAME, JUSH, SERVER, DB, ME, LANG
  _drivers/           # classe Adminer\Driver des 5 drivers (référence seule, voir plus bas)
    mysql.php  pgsql.php  sqlite.php  mssql.php  oracle.php
```

Les fichiers purement procéduraux (la plupart des pages, `index.php` lui-même,
`connect`/`coverage`/`errors`) ne déclarent aucun symbole : ils n'ont pas de stub —
sauf `sql.inc.php` (`query_error_line`). Les traductions `adminer/lang/*.inc.php`
(données) et `adminer/designs.php` (hors du graphe d'includes) sont volontairement
exclues.

## Utilisation (consommateur, ex. un projet de plugin)

Déclarer l'autoload dans le `composer.json` du projet **qui consomme** les stubs (jamais
dans celui d'Adminer : les stubs doubleraient les classes réelles). Les chemins sont
relatifs à l'emplacement de ces stubs.

```json
{
    "autoload": {
        "psr-4": {
            "Adminer\\": "stubs/Adminer/"
        },
        "files": [
            "stubs/_constants.php",
            "stubs/_functions/auth.php",
            "stubs/_functions/compress.php",
            "stubs/_functions/create.php",
            "stubs/_functions/decompress.php",
            "stubs/_functions/design.php",
            "stubs/_functions/driver.php",
            "stubs/_functions/editing.php",
            "stubs/_functions/functions.php",
            "stubs/_functions/html.php",
            "stubs/_functions/lang.php",
            "stubs/_functions/schema.php",
            "stubs/_functions/sql.php",
            "stubs/_functions/table.php",
            "stubs/_functions/type.php",
            "stubs/_functions/user.php",
            "stubs/_functions/xxtea.php"
        ]
    }
}
```

`_drivers/` est **hors autoload** : les cinq fichiers déclarent tous `Adminer\Driver` (un
seul driver est chargé à l'exécution), donc ni PSR-4 (nom de fichier ≠ nom de classe) ni
`files` (redéclaration) ne s'y appliquent. Pour l'outillage, pointez-les en référence seule,
par ex. `scanDirectories: [stubs/_drivers]` côté PHPStan, ou laissez l'IDE les indexer.

## Compatibilité PSR-4

Validée par `composer dump-autoload --optimize --strict-psr` (aucune violation) : une classe
unique par fichier, nom de fichier = nom de classe, FQCN `Adminer\<Classe>` inchangés par
rapport au code réel.

Les noms de fichiers en PascalCase (`TmpFile.php`) et les méthodes `snake_case`
(`SqlDb::next_result`) qu'impose PSR-4 **entrent en conflit** avec les règles
`Generic.Files.LowercasedFilename` et `PSR1.Methods.CamelCapsMethodName` du standard du
projet. `stubs/` est donc exclu de `phpcs` (voir `conf/phpcs.xml`), comme `vendor/` et
`node_modules/`. Le style interne (tabulations, K&R) reste néanmoins appliqué.

## Régénération

Pipeline en quatre temps. Les outils (`php-stubs/generator` basé sur `nikic/php-parser`) ne
sont **pas** des dépendances du projet : on les installe dans un dossier jetable, hors dépôt.

> Important : utiliser un PHP **7.1+** explicite. Le `php` du PATH peut résoudre vers une
> version trop ancienne selon la configuration de la machine.

1. **Générer** un stub par fichier source (classes + fonctions + constantes), corps vidés,
   avec `generate-stubs --force --functions --classes --interfaces --traits --enums
   --constants` sur `adminer/index.php`, `adminer/*.inc.php`, `adminer/include/*.inc.php` et
   `adminer/drivers/*.inc.php`.
2. **Supprimer** les stubs vides (fichiers réduits à `<?php`, aucun symbole).
3. **Découper** chaque fichier en layout PSR-4 : un script `nikic/php-parser` tranche par
   numéros de ligne (préserve formatage et phpdocs) et route chaque nœud — classe unique →
   `Adminer/<Classe>.php`, classe `Driver` d'un driver → `_drivers/<driver>.php`, fonctions →
   `_functions/<source>.php`, `define()` → `_constants.php`.
4. **Neutraliser** à la main les valeurs des `define()` (le générateur inline l'expression
   runtime) en littéraux typés — pour un stub seule l'existence de la constante compte, et
   cela évite références indéfinies, précédence booléenne et lignes trop longues.
5. **Rendre PHP 5.6-compatible** : `php dist/stubs/_strip_php7_types.php` — enlève les types
   PHP 7+ et complète les PHPDoc (voir [Compatibilité PHP 5.6](#compatibilité-php-56)).

Après régénération, vérifier : `php -l` sur chaque fichier, et
`composer dump-autoload --optimize --strict-psr` depuis un `composer.json` de test pointant
`Adminer\\` sur `stubs/Adminer/`.

## Notes

- `stubs/` n'est couvert ni par `phpcs` (exclu), ni par `phpstan`, ni par `eslint` (voir
  `paths:` dans `conf/phpstan.neon`).
- Régénérer les stubs après un changement d'API visible.
