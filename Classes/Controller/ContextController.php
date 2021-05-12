<?php

/**
 * ContextController.
 */
declare(strict_types=1);

namespace HDNET\ResponsiveContent\Controller;

use HDNET\Autoloader\Annotation\Plugin;
use HDNET\ResponsiveContent\Loader\ContextLoader;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * ContextController.
 */
class ContextController extends AbstractController
{

    /**
     * Queue.
     *
     * @var array
     */
    protected static $queue = [];

    /**
     * Main action.
     *
     * @Plugin("Context")
     *
     * @throws \Exception
     */
    public function indexAction()
    {
        $context = \trim((string) $this->settings['context']);
        $previous = (int) $this->settings['previous'];
        $contextCount = \count(self::$queue);

        if ($previous && $contextCount > 1) {
            $previous--;
            if (!isset(self::$queue[$contextCount - $previous])) {
                $previous = 0;
            }
            $context = self::$queue[$contextCount - $previous];
        }

        // End
        if ('' === $context) {
            $content = '';
            if (!empty(self::$queue)) {
                $content = $this->endContext(self::$queue[$contextCount - 1]);
            }
            self::$queue = [];

            return $content;
        }

        if (empty(self::$queue)) {
            $content = $this->startContext($context);
            self::$queue[] = $context;

            return $content;
        }

        $content = $this->endContext(self::$queue[$contextCount - 1]);
        $content .= $this->startContext($context);
        self::$queue[] = $context;

        return $content;
    }

    /**
     * Select values for BE selection.
     *
     * @param array $config
     * @param $parentObject
     */
    public function selectValues(array &$config, $parentObject): void
    {
        $context = ContextLoader::getCurrentContexts();
        foreach ($context as $item) {
            $config['items'][] = [
                $item['label'],
                $item['name'],
                $item['iconIdentifier'],
            ];
        }
    }

    /**
     * Start context.
     *
     * @param string $name
     *
     * @return string
     * @throws \Exception
     */
    protected function startContext($name): string
    {
        $content = '';
        if ($this->isDebugMode()) {
            $content .= 'START(' . $name . ')';
        }
        return $content . $this->getTemplateParts($name)[0];
    }

    /**
     * End context.
     *
     * @param string $name
     *
     * @return string
     * @throws \Exception
     */
    protected function endContext($name): string
    {
        $content = $this->getTemplateParts($name)[1];
        if ($this->isDebugMode()) {
            $content .= 'END(' . $name . ')';
        }
        return $content;
    }

    /**
     * Get template parts.
     *
     * @param string $name
     *
     * @return array
     * @throws \Exception
     */
    protected function getTemplateParts(string $name): array
    {
        $config = $this->getContextConfiguration($name);
        $keyHash = GeneralUtility::shortMD5((string) \time());
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $settings = $this->settings;
        if (isset($settings['image']) && MathUtility::canBeInterpretedAsInteger($settings['image'])) {
            $settings['image'] = GeneralUtility::makeInstance(ResourceFactory::class)->getFileReferenceObject($settings['image']);
        }
        $view->assign('settings', $settings);
        $view->assign('content', $keyHash);
        if (!\is_file(GeneralUtility::getFileAbsFileName($config['path']))) {
            throw new \Exception('Invalid context configuration: ' . $name, 12378123);
        }
        $view->setTemplatePathAndFilename($config['path']);

        return \explode($keyHash, $view->render());
    }

    /**
     * Get context configuration.
     *
     * @param string $name
     *
     * @return array
     * @throws \Exception
     */
    protected function getContextConfiguration(string $name): array
    {
        $contexts = ContextLoader::getCurrentContexts();
        foreach ($contexts as $context) {
            if ($context['name'] === $name) {
                return $context;
            }
        }
        throw new \Exception('Invalid context name: ' . $name, 435645);
    }

    protected function isDebugMode(): bool
    {
        return (bool) $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['responsive_content']['debugMode'];
    }
}
