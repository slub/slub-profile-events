<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-events
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileEvents\Http;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slub\SlubProfileEvents\Domain\Model\Dto\ApiConfiguration;
use TYPO3\CMS\Core\Utility\ArrayUtility;

class Request
{
    public array $options = [
        'headers' => [
            'Cache-Control' => 'no-cache'
        ],
        'allow_redirects' => false
    ];
    protected LoggerInterface $logger;
    protected RequestFactoryInterface $requestFactory;
    protected ApiConfiguration $apiConfiguration;

    /**
     * @param LoggerInterface $logger
     * @param RequestFactoryInterface $requestFactory
     * @param ApiConfiguration $apiConfiguration
     */
    public function __construct(
        LoggerInterface $logger,
        RequestFactoryInterface $requestFactory,
        ApiConfiguration $apiConfiguration
    ) {
        $this->logger = $logger;
        $this->requestFactory = $requestFactory;
        $this->apiConfiguration = $apiConfiguration;
    }

    /**
     * @param string $uri
     * @param string $method
     * @param array $options
     * @return array|null
     */
    public function process($uri = '', $method = 'GET', array $options = []): ?array
    {
        try {
            $this->addAuthentication();

            $options = $this->mergeOptions($this->options, $options);
            $response = $this->requestFactory->request($uri, $method, $options);

            return $this->getContent($response, $uri);
        } catch (RequestException $e) {
            /** @extensionScannerIgnoreLine */
            $this->logger->error($e->getMessage());

            return null;
        }
    }

    /**
     * @param array $default
     * @param array $new
     * @return array
     */
    protected function mergeOptions(array $default, array $new): array
    {
        if (count($new) > 0) {
            ArrayUtility::mergeRecursiveWithOverrule($default, $new);
        }

        return $default;
    }

    /**
     * @param ResponseInterface $response
     * @param string $uri
     * @return array|null
     */
    protected function getContent(ResponseInterface $response, $uri = ''): ?array
    {
        $content = '';

        if ($response->getStatusCode() === 200 &&
            strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0
        ) {
            $content = (array)json_decode($response->getBody()->getContents(), true);
        }

        if (empty($content)) {
            $this->logger->warning(
                'Requesting {request} was not successful, got status code {status} ({reason})',
                [
                    'request' => $uri,
                    'status' => $response->getStatusCode(),
                    'reason' => $response->getReasonPhrase(),
                ]
            );

            return null;
        }

        return $content;
    }

    protected function addAuthentication(): void
    {
        $username = $this->apiConfiguration->getAuthenticationUsername();
        $password = $this->apiConfiguration->getAuthenticationPassword();

        $this->options['headers']['Authorization'] = 'Basic ' . base64_encode($username . ':' . $password);
    }
}
