<?php

defined('TYPO3') || die();

// Add tsconfig page
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '@import "EXT:slub_profile_events/Configuration/TsConfig/Page.tsconfig"'
);

// Configure plugin - event list
TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'SlubProfileEvents',
    'EventList',
    [
        Slub\SlubProfileEvents\Controller\EventController::class => 'list'
    ],
    [
        Slub\SlubProfileEvents\Controller\EventController::class => 'list'
    ],
    TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

/**
 * @todo Refactor icon configuration
 *
 * Still necessary to test the icons
 * In master or v11.4 (2021-09-07) the icons should work by the Icons.php in Configuration
 * It is already prepared
 * Remove the following code when the other works
 */
/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
);

$iconRegistry->registerIcon(
    'slubprofileevents-wizard-eventlist',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:slub_profile_events/Resources/Public/Icons/Wizard/eventlist.svg']
);

$iconRegistry->registerIcon(
    'slubprofileevents-overlay-extension',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:slub_profile_events/Resources/Public/Icons/Overlay/extension.svg']
);
