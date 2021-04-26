<?php

declare(strict_types=1);

namespace HDNET\ResponsiveContent;

use HDNET\ResponsiveContent\Loader\ContextLoader;

class Registry
{
    /**
     * Get the default autoloader configuration.
     */
    public static function getAutoloaderConfiguration(): array
    {
        return [
            'StaticTyposcript',
            'SmartObjects',
            'Hooks',
            'TcaFiles',
            'FluidNamespace',
            'Plugins',
            'FlexForms',
            'Icon',
            ContextLoader::class,
        ];
    }
}
