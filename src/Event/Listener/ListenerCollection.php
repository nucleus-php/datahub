<?php

namespace NucleusPhp\DataHub\Event\Listener;

use NucleusPhp\DataHub\Event\Event;

/**
 * Class ListenerCollection
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class ListenerCollection
{

    /**
     * @var Listener[][]
     */
    private $eventListeners = [];

    /**
     * Collection constructor
     */
    public function __construct()
    {
        $config = require(ROOT_DIR . '/config/event_listeners.php');
        foreach ($config as $eventType => $listenersList) {
            foreach ($listenersList as $listenerName => $listenerHandlerCallable) {
                $this->eventListeners[$eventType][$listenerName] = new Listener($listenerName, $listenerHandlerCallable);
            }
        }
    }

    /**
     * @param string $eventType
     * @return Listener[]
     */
    public function getListenersForType($eventType)
    {
        if (!array_key_exists($eventType, $this->eventListeners)) {
            throw new \OutOfBoundsException('No job listeners registered for this type of job');
        }
        return $this->eventListeners[$eventType];
    }


    /**
     * @param Event $event
     */
    public function handleForEvent($event)
    {
        $listeners = $this->getListenersForType($event->getTypeAsString());
        foreach ($listeners as $listener) {
            $listener->handle($event);
        }
    }

}