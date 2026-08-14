<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

/**
 * Style (spaces around !, brace position, aligned operators, …) is owned by
 * PHP-CS-Fixer (.php-cs-fixer.dist.php). Keep paths in sync with that Finder;
 * `composer rector:fix` re-runs CS Fixer after Rector so output stays compliant.
 */
return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src'
    ])
    ->withPhpSets()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
    )
    // Keep global FQCNs (\Throwable, \DateTime, …) — do not add `use Throwable;`.
    ->withImportNames(
        importShortClasses: false,
        removeUnusedImports: true,
    );
