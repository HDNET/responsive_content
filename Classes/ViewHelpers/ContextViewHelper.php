<?php


declare(strict_types = 1);

namespace HDNET\ResponsiveContent\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * ContextViewHelper.
 */
class ContextViewHelper extends AbstractViewHelper
{
    // Compile
    use CompileWithRenderStatic;

    /**
     * Disable escaping of child nodes' output.
     *
     * @var bool
     */
    protected $escapeChildren = false;

    /**
     * Disable escaping of this node's output.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Init arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('context', 'string', 'Context Template name', false, '');
        $this->registerArgument('finish', 'boolean', 'Finish the last context', false, false);
        $this->registerArgument('finishOnly', 'boolean', 'Finish the context, if there are open contexts', false, false);
        $this->registerArgument('previous', 'boolean', 'Return to the previous context', false, false);
    }

    /**
     * @param array                     $arguments
     * @param \Closure                  $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $config = [
            'userFunc' => 'TYPO3\CMS\Extbase\Core\Bootstrap->run',
            'extensionName' => 'ResponsiveContent',
            'pluginName' => 'Context',
            'vendorName' => 'HDNET',
        ];
        if ((bool)$arguments['finishOnly']) {
            return self::renderUserObject($config);
        }
        $start = $config;
        $start['settings.']['context'] = (string)$arguments['context'];
        $content = self::renderUserObject($start);
        $content .= $renderChildrenClosure();
        if ((bool)$arguments['finish']) {
            $content .= self::renderUserObject($config);
        } elseif ((bool)$arguments['previous']) {
            $prevoius = $config;
            $prevoius['settings.']['previous'] = 1;
            $content .= self::renderUserObject($prevoius);
        }

        return $content;
    }

    /**
     * Render the given USER configuration.
     *
     * @param array $configuration
     *
     * @return string
     */
    protected static function renderUserObject(array $configuration): string
    {
        static $contentObjectRenderer = null;
        if (null === $contentObjectRenderer) {
            $contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        }

        return (string)$contentObjectRenderer->cObjGetSingle('USER', $configuration);
    }
}
