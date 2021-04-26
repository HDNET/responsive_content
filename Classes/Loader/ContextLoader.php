<?php

declare(strict_types=1);

namespace HDNET\ResponsiveContent\Loader;

use HDNET\Autoloader\Loader;
use HDNET\Autoloader\LoaderInterface;
use HDNET\Autoloader\Utility\FileUtility;
use HDNET\Autoloader\Utility\TranslateUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * ContextLoader.
 */
class ContextLoader implements LoaderInterface
{
    /**
     * Current context.
     */
    protected static array $currentContexts = [];

    /**
     * Get all the complex data and information for the loader.
     * This return value will be cached and stored in the core_cache of TYPO3.
     * There is no file monitoring for this cache.
     *
     * @param Loader $loader
     * @param int    $type
     *
     * @throws \Exception
     *
     * @return array
     */
    public function prepareLoader(Loader $loader, int $type): array
    {
        $contexts = [];
        $commandPath = ExtensionManagementUtility::extPath($loader->getExtensionKey()) . 'Resources/Private/Templates/Context/';
        $files = FileUtility::getBaseFilesWithExtensionInDir($commandPath, 'html');

        foreach ($files as $file) {
            $pathInfo = PathUtility::pathinfo($file);
            $translationKey = 'context.' . $pathInfo['filename'];
            if (LoaderInterface::EXT_TABLES === $type) {
                TranslateUtility::assureLabel($translationKey, $loader->getExtensionKey(), $pathInfo['filename']);
            }

            $path = 'EXT:' . $loader->getExtensionKey() . '/Resources/Private/Templates/Context/' . $file;
            $label = TranslateUtility::getLllString($translationKey, $loader->getExtensionKey());
            $iconIdentifier = \mb_strtolower(str_replace('_', '-', $loader->getExtensionKey()) . '-context-' . $pathInfo['filename']);

            $contexts[] = [
                'name' => $pathInfo['filename'],
                'iconIdentifier' => $iconIdentifier,
                'file' => $file,
                'path' => $path,
                'label' => $label,
            ];
        }

        return $contexts;
    }

    /**
     * Run the loading process for the ext_tables.php file.
     *
     * @param Loader $loader
     * @param array  $loaderInformation
     */
    public function loadExtensionTables(Loader $loader, array $loaderInformation): void
    {
        self::$currentContexts = $loaderInformation;

        ExtensionManagementUtility::addPageTSConfig('
mod.wizards.newContentElement.wizardItems.context {
    show = *
    header = ' . TranslateUtility::getLllOrHelpMessage('wizard.context.header', $loader->getExtensionKey()) . '
}');

        foreach ($loaderInformation as $e => $config) {
            $name = $config['name'];

            ExtensionManagementUtility::addPageTSConfig('
mod.wizards.newContentElement.wizardItems.context.elements.' . $name . ' {
    title = ' . TranslateUtility::getLllOrHelpMessage('context.' . $name, $loader->getExtensionKey()) . '
    description = ' . TranslateUtility::getLllOrHelpMessage(
                'wizard.' . $name . '.description',
                $loader->getExtensionKey()
            ) . '
    iconIdentifier = ' . $config['iconIdentifier'] . '
    tt_content_defValues {
        CType = list
        list_type = responsivecontent_context
        frame_class = none
        sectionIndex = 0
        header_layout = 100
        pi_flexform = <?xml version="1.0" encoding="utf-8" standalone="yes" ?> <T3FlexForms> <data> <sheet index="sDEF"> <language index="lDEF"><field index="settings.context"> <value index="vDEF">' . $name . '</value> </field> </language> </sheet> </data> </T3FlexForms>
    }
}
mod.wizards.newContentElement.wizardItems.context.show := addToList(' . $name . ')');
        }
    }

    /**
     * Run the loading process for the ext_localconf.php file.
     *
     * @param Loader $loader
     * @param array  $loaderInformation
     */
    public function loadExtensionConfiguration(Loader $loader, array $loaderInformation): void
    {
        self::$currentContexts = $loaderInformation;
    }

    /**
     * Get the current contexts.
     *
     * @return array
     */
    public static function getCurrentContexts(): array
    {
        return self::$currentContexts;
    }
}
