<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-events
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileEvents\Service;

class EventService
{
    protected RequestService $requestService;

    /**
     * EventService constructor.
     * @param RequestService $requestService
     */
    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        // filter by get params is missing
        // use dto for this like eventDemand
        $arguments = [
            'tx_slubevents_apieventlist' => [
                'limit' => 1
            ]
        ];

        $uri = $this->requestService->buildListUri($arguments);

        return $this->requestService->process($uri) ?? [];
    }
}
