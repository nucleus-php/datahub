<?php

namespace NucleusPhp\DataHub\Event\Dispatcher;

use NucleusPhp\DataHub\Event\Event;
use NucleusPhp\DataHub\Event\Listener\ListenerCollection;

/**
 * Class Dispatcher
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class Dispatcher
{

    /**
     * @var Event
     */
    private $event;

    /**
     * @var ListenerCollection
     */
    private $eventListenerCollection;

    /**
     * Dispatcher constructor
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function dispatch()
    {
        $this->eventListenerCollection = new ListenerCollection();
        $this->eventListenerCollection->handleForEvent($this->event);
    }

}