<?php

declare(strict_types = 1);

namespace HDNET\ResponsiveContent\Service;

class ContextColorService
{

    /**
     * getColorItems
     * @param $param
     * @param $object
     */
    public function getColorItems(&$param, $object)
    {
        $colors = (array)($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['responsive_content']['contextColors'] ?? []);
        foreach ($colors as $key => $value) {
            $param['items'][] = [
                $value,
                $key,
                null // icon
            ];
        }
    }
}
