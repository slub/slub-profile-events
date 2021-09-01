<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-events
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileEvents\Controller;

use Psr\Http\Message\ResponseInterface;
use Slub\SlubProfileEvents\Mvc\View\JsonView;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class EventController
 * @package Slub\SlubProfileEvents
 */
class EventController extends ActionController
{
    protected $view;
    protected $defaultViewObjectName = JsonView::class;

    /**
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $events = [
            'items' => [
                'test' => 1,
                'probe' => 2
            ]
        ];

        $this->view->setVariablesToRender(['events']);
        $this->view->assign('events', $events);

        return $this->jsonResponse();
    }
}
