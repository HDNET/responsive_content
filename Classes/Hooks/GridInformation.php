<?php

declare(strict_types=1);

namespace HDNET\ResponsiveContent\Hooks;

use HDNET\Autoloader\Annotation\Hook;
use HDNET\ResponsiveContent\Utility\CalculationUtility;
use TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * GridInformation.
 *
 * @Hook("TYPO3_CONF_VARS|SC_OPTIONS|cms/layout/class.tx_cms_layout.php|tt_content_drawItem")
 */
class GridInformation implements PageLayoutViewDrawItemHookInterface
{
    /**
     * Header, content.
     *
     * @var array
     */
    protected $info = ['header'];

    /**
     * Preprocesses the preview rendering of a content element.
     *
     * @param PageLayoutView $parentObject Calling parent object
     * @param bool $drawItem Whether to draw the item using the default functionalities
     * @param string $headerContent Header content
     * @param string $itemContent Item content
     * @param array $row Record row of tt_content
     */
    public function preProcess(PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row): void
    {
        if (!\in_array('content', $this->info, true)) {
            return;
        }
        $information = $this->getGridInformation($row);

        if (!empty($information)) {
            $headerContent .= '<table class="table table-striped table-hover">';
            foreach ($information as $key => $value) {
                $headerContent .= '<tr><td>' . $key . '</td><td>' . $value . '</td></tr>';
            }
            $headerContent .= '</table>';
        }
    }

    /**
     * @Hook("TYPO3_CONF_VARS|SC_OPTIONS|GLOBAL|recStatInfoHooks")
     *
     * @param array $params
     * @param mixed $object
     *
     * @return string
     */
    public function addGridIcons(array $params, $object)
    {
        if (!isset($params[0]) || $params[0] !== 'tt_content') {
            return '';
        }
        if (!\in_array('header', $this->info, true)) {
            return '';
        }
        $path = '/typo3conf/ext/responsive_content/Resources/Public/Icons/Backend/';
        $information = $this->getGridInformation($params[2]);
        $out = [
            '<img src="' . $path . 'ico-smartphone.png" width="20" /> ' . $this->getNumber((int) ($information['small'] ?? 0)),
            '<img src="' . $path . 'ico-tablet.png" width="20" /> ' . $this->getNumber((int) ($information['medium'] ?? 0)),
            '<img src="' . $path . 'ico-desktop.png" width="20" /> ' . $this->getNumber((int) ($information['large'] ?? 0)),
        ];

        return '&nbsp;' . \implode('&nbsp;', $out);
    }

    protected function getNumber(int $number): string
    {
        if ($number === 0) {
            $number = 12;
        }
        return $number . ' (' . CalculationUtility::getPercentByCols($number).'%)';
    }

    /**
     * @param $row
     *
     * @return array
     */
    public function getGridInformation($row)
    {
        $information = [];

        $cellWidthSmall = MathUtility::forceIntegerInRange($row['cell_width_small'], 0, 100);
        if ($cellWidthSmall > 0 && $cellWidthSmall < 100) {
            $information['small'] = $cellWidthSmall;
        }
        $cellWidthMedium = MathUtility::forceIntegerInRange($row['cell_width_medium'], 0, 100);
        if ($cellWidthMedium > 0 && $cellWidthMedium < 100) {
            $information['medium'] = $cellWidthMedium;
        }
        $cellWidthLarge = MathUtility::forceIntegerInRange($row['cell_width_large'], 0, 100);
        if ($cellWidthLarge > 0 && $cellWidthLarge < 100) {
            $information['large'] = $cellWidthLarge;
        }

        $cellOffsetSmall = MathUtility::forceIntegerInRange($row['cell_offset_small'], 0, 100);
        $cellOffsetMedium = MathUtility::forceIntegerInRange($row['cell_offset_medium'], 0, 100);
        $cellOffsetLarge = MathUtility::forceIntegerInRange($row['cell_offset_large'], 0, 100);
        $isOneOffsetSet = (bool) ($cellOffsetSmall + $cellOffsetMedium + $cellOffsetLarge);
        if(!$isOneOffsetSet) {
            return $information;
        }

        if ($cellOffsetSmall >= 0 && $cellOffsetSmall < 100) {
            $information['smallOffset'] = $cellOffsetSmall;
        }
        if ($cellOffsetMedium >= 0 && $cellOffsetMedium < 100) {
            $information['mediumOffset'] = $cellOffsetMedium;
        }
        if ($cellOffsetLarge >= 0 && $cellOffsetLarge < 100) {
            $information['largeOffset'] = $cellOffsetLarge;
        }

        return $information;
    }
}
