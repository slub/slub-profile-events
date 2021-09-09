<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-events
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileEvents\Service;

use Slub\SlubProfileEvents\Validation\EventArgumentValidator;

class EventService
{
    protected EventArgumentValidator $eventArgumentValidator;
    protected RequestService $requestService;

    /**
     * EventService constructor.
     * @param EventArgumentValidator $eventArgumentValidator
     * @param RequestService $requestService
     */
    public function __construct(
        EventArgumentValidator $eventArgumentValidator,
        RequestService $requestService
    ) {
        $this->eventArgumentValidator = $eventArgumentValidator;
        $this->requestService = $requestService;
    }

    /**
     * @param array $arguments
     * @return array
     */
    public function getEvents(array $arguments): array
    {
        $validatedArguments = $this->eventArgumentValidator->validateArguments($arguments);
        $uri = $this->requestService->buildUri($validatedArguments);

        return $this->requestService->process($uri) ?? [];
    }
}
