<?php

use Slub\SlubProfileEvents\Controller\EventController;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die();

// Add tsconfig page
ExtensionManagementUtility::addPageTSConfig(
    '@import "EXT:slub_profile_events/Configuration/TsConfig/Page.tsconfig"'
);

// Configure plugin - event list
ExtensionUtility::configurePlugin(
    'SlubProfileEvents',
    'EventList',
    [
        EventController::class => 'list'
    ],
    [
        EventController::class => 'list'
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - event list user
ExtensionUtility::configurePlugin(
    'SlubProfileEvents',
    'EventListUser',
    [
        EventController::class => 'listUser'
    ],
    [
        EventController::class => 'listUser'
    ],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
