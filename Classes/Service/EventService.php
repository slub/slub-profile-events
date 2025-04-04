<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-events
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileEvents\Service;

use Slub\SlubProfileEvents\Http\Request;
use Slub\SlubProfileEvents\Routing\UriGenerator;
use Slub\SlubProfileEvents\Sanitization\EventArgumentSanitization;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;

class EventService
{
    protected EventArgumentSanitization $eventArgumentSanitization;
    protected Request $request;
    protected UriGenerator $uriGenerator;

    /**
     * @param EventArgumentSanitization $eventArgumentSanitization
     * @param Request $request
     * @param UriGenerator $uriGenerator
     */
    public function __construct(
        EventArgumentSanitization $eventArgumentSanitization,
        Request $request,
        UriGenerator $uriGenerator
    ) {
        $this->eventArgumentSanitization = $eventArgumentSanitization;
        $this->request = $request;
        $this->uriGenerator = $uriGenerator;
    }

    /**
     * @param array $arguments
     * @return array
     * @throws AspectNotFoundException
     */
    public function getEvents(array $arguments): array
    {
        $sanitizedArguments = $this->eventArgumentSanitization->sanitizeDefaultArguments($arguments);
        $uri = $this->uriGenerator->buildEventList($sanitizedArguments);

        return $this->request->process($uri) ?? [];
    }

    /**
     * @param array $arguments
     * @return array
     * @throws AspectNotFoundException
     */
    public function getEventsUser(array $arguments): array
    {
        $sanitizedUserArguments = $this->eventArgumentSanitization->sanitizeUserArguments($arguments);
        $uri = $this->uriGenerator->buildEventListUser($sanitizedUserArguments);

        return $this->request->process($uri) ?? [];
    }
}
