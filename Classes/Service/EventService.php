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
    protected ApiService $apiService;

    /**
     * EventService constructor.
     * @param ApiService $apiService
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        // filter by get params is missing
        // use dto for this like eventDemand
        //$url = '?type=1452982642&tx_slubevents_apieventlist[limit]=2';

        $arguments = [
            'tx_slubevents_apieventlist' => [
                'limit' => 1
            ]
        ];

        $uri = $this->apiService->buildListUri($arguments);

        return $this->apiService->handle($uri) ?? [];
    }
}
