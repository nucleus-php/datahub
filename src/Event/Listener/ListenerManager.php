<?php

namespace NucleusPhp\DataHub\Event\Listener;

use NucleusPhp\DataHub\Event\EventInterface;

/**
 * Class ListenerManager
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class ListenerManager
{

    /**
     * @var ListenerInterface[][]
     */
    private static $eventListeners = [];

    /**
     * @param string $eventType
     * @param string $listenerName
     * @param callable|ListenerInterface $listenerHandlerCallable
     * @throws \UnexpectedValueException
     */
    public static function addEventListener($eventType, $listenerName, callable $listenerHandlerCallable)
    {
        if (!array_key_exists($eventType, self::$eventListeners)) {
            self::$eventListeners[$eventType] = [];
        } elseif (array_key_exists($listenerName, self::$eventListeners[$eventType])) {
            throw new \UnexpectedValueException(sprintf(
                'An event listener for event type "%s" with the name "%s" already exists',
                $eventType, $listenerName
            ));
        }
        self::$eventListeners[$eventType][$listenerName] = (!$listenerHandlerCallable instanceof ListenerInterface
            ? new Listener($listenerName, $listenerHandlerCallable)
            : $listenerHandlerCallable);
    }

    /**
     * @param string $eventType
     * @param array<string, callable|ListenerInterface> $listeners
     */
    public static function addJobExecutors($eventType, array $listeners)
    {
        foreach ($listeners as $listenerName => $listenerHandlerCallable) {
            static::addEventListener($eventType, $listenerName, $listenerHandlerCallable);
        }
    }

    /**
     * @param string $eventType
     * @return ListenerInterface[]
     */
    public function getListenersForType($eventType)
    {
        if (!array_key_exists($eventType, self::$eventListeners)) {
            throw new \OutOfBoundsException('No job listeners registered for this type of job');
        }
        return self::$eventListeners[$eventType];
    }

    /**
     * @param EventInterface $event
     */
    public function handleEvent(EventInterface $event)
    {
        $listeners = $this->getListenersForType($event->getTypeAsString());
        foreach ($listeners as $listener) {
            $listener->handle($event);
        }
    }

}