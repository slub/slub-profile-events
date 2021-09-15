<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-events
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileEvents\Domain\Model\Dto;

use Exception;
use Slub\SlubProfileEvents\Domain\Model\Dto\Request\RequestArgumentIdentifierInterface;
use Slub\SlubProfileEvents\Domain\Model\Dto\Request\RequestArgumentIdentifierTrait;
use Slub\SlubProfileEvents\Domain\Model\Dto\Request\RequestUriInterface;
use Slub\SlubProfileEvents\Domain\Model\Dto\Request\RequestUriTrait;
use Slub\SlubProfileEvents\Utility\ConstantsUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration as CoreExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ApiEventListUserConfiguration implements RequestUriInterface, RequestArgumentIdentifierInterface
{
    use RequestUriTrait;
    use RequestArgumentIdentifierTrait;

    public const KEY = 'eventListUser';

    public function __construct()
    {
        $configuration = $this->getConfiguration(ConstantsUtility::EXTENSION_KEY)[self::KEY];

        empty($configuration['requestUri']) ?: $this->setRequestUri($configuration['requestUri']);
        empty($configuration['requestArgumentIdentifier']) ?: $this->setRequestArgumentIdentifier($configuration['requestArgumentIdentifier']);
    }

    /**
     * @param string $extensionKey
     * @return array
     */
    protected function getConfiguration($extensionKey = ''): array
    {
        /** @var CoreExtensionConfiguration $coreExtensionConfiguration */
        $coreExtensionConfiguration = GeneralUtility::makeInstance(CoreExtensionConfiguration::class);

        try {
            return $coreExtensionConfiguration->get($extensionKey);
        } catch (Exception $e) {
            return [];
        }
    }
}
