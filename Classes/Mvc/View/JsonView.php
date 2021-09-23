<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-events
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileEvents\Mvc\View;

use TYPO3\CMS\Extbase\Mvc\View\JsonView as ExtbaseJsonView;

class JsonView extends ExtbaseJsonView
{
    /**
     * The rendering configuration for this JSON view which
     * determines which properties of each variable to render.
     * In default all data are given.
     *
     * You can exclude fields like:
     *
     * 'events' => [
     *     '_descendAll' => [
     *         '_exclude' => [
     *             'categories',
     *             'contact',
     *             'discipline'
     *         ]
     *     ]
     * ]
     */
    protected array $eventConfiguration = [
        'events' => [
        ],
        'eventsUser' => [
        ]
    ];

    public function __construct()
    {
        $this->setConfiguration($this->eventConfiguration);
    }
}
