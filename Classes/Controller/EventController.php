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
use Slub\SlubProfileEvents\Service\EventService;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class EventController extends ActionController
{
    protected $view;
    protected $defaultViewObjectName = JsonView::class;
    protected EventService $eventService;

    /**
     * @param EventService $eventService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Get a list of events depend on arguments.
     *
     * @return ResponseInterface
     * @throws AspectNotFoundException
     */
    public function listAction(): ResponseInterface
    {
        $events = $this->eventService->getEvents($this->request->getArguments());

        $this->view->setVariablesToRender(['events']);
        $this->view->assign('events', $events);

        return $this->jsonResponse();
    }

    /**
     * Get a list of events by a specific user depend on arguments.
     *
     * @return ResponseInterface
     * @throws AspectNotFoundException
     */
    public function listUserAction(): ResponseInterface
    {
        $eventsUser = $this->eventService->getEventsUser($this->request->getArguments());

        $this->view->setVariablesToRender(['eventsUser']);
        $this->view->assign('eventsUser', $eventsUser);

        return $this->jsonResponse();
    }
}
