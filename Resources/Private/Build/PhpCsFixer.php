<?php

declare(strict_types=1);
echo dirname(__DIR__, 3) . '/.Build/vendor/autoload.php';
require dirname(__DIR__, 3) . '/.Build/vendor/autoload.php';

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(dirname(__DIR__, 3) . '/Classes')
    )
    ->setRules([
        '@PSR12' => true,
        '@PSR12:risky' => true,
        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,
    ]);
