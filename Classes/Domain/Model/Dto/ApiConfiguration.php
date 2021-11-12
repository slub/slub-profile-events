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
use Slub\SlubProfileEvents\Utility\ConstantsUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ApiConfiguration
{
    protected string $authenticationUsername = '';
    protected string $authenticationPassword = '';

    public function __construct()
    {
        $configuration = $this->getConfiguration(ConstantsUtility::EXTENSION_KEY);

        empty($configuration['authenticationUsername']) ?: $this->setAuthenticationUsername($configuration['authenticationUsername']);
        empty($configuration['authenticationPassword']) ?: $this->setAuthenticationPassword($configuration['authenticationPassword']);
    }

    /**
     * @return string
     */
    public function getAuthenticationUsername(): string
    {
        return $this->authenticationUsername;
    }

    /**
     * @param string $authenticationUsername
     */
    public function setAuthenticationUsername($authenticationUsername = ''): void
    {
        $this->authenticationUsername = $authenticationUsername;
    }

    /**
     * @return string
     */
    public function getAuthenticationPassword(): string
    {
        return $this->authenticationPassword;
    }

    /**
     * @param string $authenticationPassword
     */
    public function setAuthenticationPassword($authenticationPassword = ''): void
    {
        $this->authenticationPassword = $authenticationPassword;
    }

    /**
     * @param string $extensionKey
     * @return array
     */
    protected function getConfiguration($extensionKey = ''): array
    {
        /** @var ExtensionConfiguration $extensionConfiguration */
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);

        try {
            return $extensionConfiguration->get($extensionKey);
        } catch (Exception $e) {
            return [];
        }
    }
}
