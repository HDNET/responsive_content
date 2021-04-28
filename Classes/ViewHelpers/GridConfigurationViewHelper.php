<?php


declare(strict_types=1);

namespace HDNET\ResponsiveContent\ViewHelpers;

use HDNET\ResponsiveContent\Hooks\GridInformation;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * GridConfigurationViewHelper.
 */
class GridConfigurationViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('data', 'array', '');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return mixed|string|null
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $gridInformation = GeneralUtility::makeInstance(GridInformation::class);
        $information = $gridInformation->getGridInformation($arguments['data']);

        $classes = [];
        foreach ($information as $size => $value) {
            $classes[] = self::mapClassName($size) . $value;
        }

        if ($classes === []) {
            $classes[] = 'col-12';
        }

        return \implode(' ', $classes);
    }

    protected static function mapClassName(string $size): string
    {
        switch ($size) {
            case 'small':
                return 'col-';
            case 'medium':
                return 'col-md-';
            case 'large':
                return 'col-lg-';
            case 'smallOffset':
                return 'offset-';
            case 'mediumOffset':
                return 'offset-md-';
            case 'largeOffset':
                return 'offset-lg-';
        }
        return 'wrong-';
    }
}
