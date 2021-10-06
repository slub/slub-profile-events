<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-events
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileEvents\Routing;

use Slub\SlubProfileEvents\Domain\Model\Dto\ApiEventListConfiguration;
use Slub\SlubProfileEvents\Domain\Model\Dto\ApiEventListUserConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class UriGenerator
{
    /**
     * @param array $additionalParameters
     * @return string
     */
    public function buildEventList(array $additionalParameters): string
    {
        /** @var ApiEventListConfiguration $apiConfiguration */
        $apiConfiguration = GeneralUtility::makeInstance(ApiEventListConfiguration::class);

        /** @extensionScannerIgnoreLine */
        $requestUri = $apiConfiguration->getRequestUri();
        $requestArgumentIdentifier = $apiConfiguration->getRequestArgumentIdentifier();

        return $this->build($requestUri, $requestArgumentIdentifier, $additionalParameters);
    }

    /**
     * @param array $additionalParameters
     * @return string
     */
    public function buildEventListUser(array $additionalParameters): string
    {
        /** @var ApiEventListUserConfiguration $apiConfiguration */
        $apiConfiguration = GeneralUtility::makeInstance(ApiEventListUserConfiguration::class);

        /** @extensionScannerIgnoreLine */
        $requestUri = $apiConfiguration->getRequestUri();
        $requestArgumentIdentifier = $apiConfiguration->getRequestArgumentIdentifier();

        return $this->build($requestUri, $requestArgumentIdentifier, $additionalParameters);
    }

    /**
     * @param string $requestUri
     * @param string $requestArgumentIdentifier
     * @param array $additionalParameters
     * @return string
     */
    protected function build(
        string $requestUri,
        string $requestArgumentIdentifier,
        array $additionalParameters
    ): string {
        $parameters = [];

        empty($requestArgumentIdentifier) ?: $parameters[$requestArgumentIdentifier] = $additionalParameters;

        if (count($parameters) > 0) {
            $requestUri .= strpos($requestUri, '?') ? '&' : '?';
            $requestUri .= http_build_query($parameters);
        }

        return $requestUri;
    }
}
