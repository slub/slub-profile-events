<?php

defined('TYPO3') || die();

(static function (string $extensionKey, array $pluginNames): void {
    $extensionName = str_replace('_', '', $extensionKey);
    $ll = [
        'backend' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_backend.xlf',
        'core' => 'LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf',
        'frontend' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf',
    ];

    // Add new group to ctype selector
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItemGroup(
        'tt_content',
        'CType',
        $extensionName,
        $ll['backend'] . ':plugin.title',
        'after:default' // Should be the same like "common" in page tsconfig
    );

    foreach ($pluginNames as $pluginName) {
        // Merge content element definition
        TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($GLOBALS['TCA']['tt_content'], [
            'ctrl' => [
                'typeicon_classes' => [
                    $extensionName . '_' . $pluginName => $extensionName . '-wizard-' . $pluginName,
                ],
            ],
            'types' => [
                $extensionName . '_' . $pluginName => [
                    'showitem' => '
                        --div--;' . $ll['core'] . ':general,
                            --palette--;;general,
                            --palette--;;headers,
                        --div--;' . $ll['core'] . ':language,
                            --palette--;;language,
                        --div--;' . $ll['core'] . ':access,
                            --palette--;;hidden,
                            --palette--;;access,
                        --div--;' . $ll['core'] . ':notes,
                            rowDescription,
                        --div--;' . $ll['core'] . ':extended',
                ],
            ],
        ]);

        // Add item to select field list (ctype)
        TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            'tt_content',
            'CType',
            [
                $ll['backend'] . ':plugin.' . $pluginName . '.title', // Title
                $extensionName . '_' . $pluginName, // CType
                $extensionName . '-wizard-' . $pluginName, // Icon identifier
                $extensionName // Item group id
            ]
        );
    }
})(
    'slub_profile_events',
    ['eventlist', 'eventlistuser']
);
