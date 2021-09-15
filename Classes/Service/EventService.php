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
use Slub\SlubProfileEvents\Validation\EventArgumentValidator;

class EventService
{
    protected EventArgumentValidator $eventArgumentValidator;
    protected Request $request;
    protected UriGenerator $uriGenerator;

    /**
     * @param EventArgumentValidator $eventArgumentValidator
     * @param Request $request
     * @param UriGenerator $uriGenerator
     */
    public function __construct(
        EventArgumentValidator $eventArgumentValidator,
        Request $request,
        UriGenerator $uriGenerator
    ) {
        $this->eventArgumentValidator = $eventArgumentValidator;
        $this->request = $request;
        $this->uriGenerator = $uriGenerator;
    }

    /**
     * @param array $arguments
     * @return array
     */
    public function getEvents(array $arguments): array
    {
        $validatedArguments = $this->eventArgumentValidator->validateDefaultArguments($arguments);
        $uri = $this->uriGenerator->buildEventList($validatedArguments);

        return $this->request->process($uri) ?? [];
    }

    /**
     * @param array $arguments
     * @return array
     */
    public function getEventsUser(array $arguments): array
    {
        $validatedUserArguments = $this->eventArgumentValidator->validateUserArguments($arguments);
        $uri = $this->uriGenerator->buildEventListUser($validatedUserArguments);

        return $this->request->process($uri) ?? [];
    }
}
