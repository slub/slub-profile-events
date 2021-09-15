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
     * @param array $additionalParameter
     * @return string
     */
    public function buildEventList(array $additionalParameter): string
    {
        /** @var ApiEventListConfiguration $apiConfiguration */
        $apiConfiguration = GeneralUtility::makeInstance(ApiEventListConfiguration::class);

        $requestUri = $apiConfiguration->getRequestUri();
        $requestArgumentIdentifier = $apiConfiguration->getRequestArgumentIdentifier();

        return $this->build($requestUri, $requestArgumentIdentifier, $additionalParameter);
    }

    /**
     * @param array $additionalParameter
     * @return string
     */
    public function buildEventListUser(array $additionalParameter): string
    {
        /** @var ApiEventListUserConfiguration $apiConfiguration */
        $apiConfiguration = GeneralUtility::makeInstance(ApiEventListUserConfiguration::class);

        $requestUri = $apiConfiguration->getRequestUri();
        $requestArgumentIdentifier = $apiConfiguration->getRequestArgumentIdentifier();

        return $this->build($requestUri, $requestArgumentIdentifier, $additionalParameter);
    }

    /**
     * @param string $requestUri
     * @param string $requestArgumentIdentifier
     * @param array $additionalParameter
     * @return string
     */
    protected function build(
        string $requestUri,
        string $requestArgumentIdentifier,
        array $additionalParameter
    ): string {
        $parameter = [];

        empty($requestArgumentIdentifier) ?: $parameter[$requestArgumentIdentifier] = $additionalParameter;

        if (count($parameter) > 0) {
            $requestUri .= strpos($requestUri, '?') ? '&' : '?';
            $requestUri .= http_build_query($parameter);
        }

        return $requestUri;
    }
}
