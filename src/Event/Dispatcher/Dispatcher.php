<?php

namespace NucleusPhp\DataHub\Event\Dispatcher;

use NucleusPhp\DataHub\Event\Event;
use NucleusPhp\DataHub\Event\EventInterface;
use NucleusPhp\DataHub\Event\Listener\ListenerManager;

/**
 * Class Dispatcher
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class Dispatcher
{

    /**
     * @var EventInterface
     */
    private $event;

    /**
     * @var ListenerManager
     */
    private $eventListenerManager;

    /**
     * Dispatcher constructor
     * @param EventInterface $event
     */
    public function __construct(EventInterface $event)
    {
        $this->event = $event;
    }

    /**
     */
    public function dispatch()
    {
        if ($this->event->isDispatched()) {
            throw new \LogicException('Event was already dispatched');
        }

        $this->eventListenerManager = new ListenerManager();
        $this->eventListenerManager->handleEvent($this->event);

        $this->event->isDispatched(true);
    }

}