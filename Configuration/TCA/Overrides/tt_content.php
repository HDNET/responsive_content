<?php

declare(strict_types=1);

use HDNET\Autoloader\Utility\ArrayUtility;
use HDNET\Autoloader\Utility\ModelUtility;
use HDNET\ResponsiveContent\Utility\CalculationUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$GLOBALS['TCA']['tt_content'] = ModelUtility::getTcaOverrideInformation('responsive_content', 'tt_content');


$items = [
    [
        '',
        '0',
    ],
];

for ($i = 1; $i <= CalculationUtility::COL_NUMBER; $i++) {
    $items[] = [
        $i . ' - ' . CalculationUtility::getPercentByCols($i) . '%',
        $i,
    ];
}

$gridConfig = [
    'type' => 'select',
    'renderType' => 'selectSingle',
    'size' => 1,
    'items' => $items,
    'default' => '0',
];

$custom = [
    'columns' => [
        'cell_width_small' => [
            'config' => $gridConfig,
        ],
        'cell_width_medium' => [
            'config' => $gridConfig,
        ],
        'cell_width_large' => [
            'config' => $gridConfig,
        ],
    ],
];

$GLOBALS['TCA']['tt_content'] = ArrayUtility::mergeRecursiveDistinct($GLOBALS['TCA']['tt_content'], $custom);

$GLOBALS['TCA']['tt_content']['palettes']['grids'] = [
    'showitem' => 'cell_width_small,cell_width_medium,cell_width_large',
];

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--palette--;LLL:EXT:responsive_content/Resources/Private/Language/locallang.xlf:palette.grid;grids'
);
