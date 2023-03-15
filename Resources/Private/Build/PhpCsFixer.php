<?php

declare(strict_types=1);

$basePath = dirname(__DIR__, 3) . '/';
require $basePath . '.Build/vendor/autoload.php';

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in($basePath . 'Classes')
            ->in($basePath . 'Configuration')
            ->in($basePath . 'Resources')
    )
    ->setRules([
        '@PSR12' => true,
        '@PSR12:risky' => true,
        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,
    ]);
