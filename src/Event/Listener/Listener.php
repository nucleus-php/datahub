<?php

namespace NucleusPhp\DataHub\Event\Listener;

/**
 * Class Listener
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class Listener
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var callable
     */
    private $handler;

    /**
     * Listener constructor
     * @param string $name
     * @param callable $handlerCallable
     * @throws \UnexpectedValueException
     */
    public function __construct($name, $handlerCallable)
    {
        $this->name = $name;
        $this->handler = $handlerCallable;
        if (!is_callable($this->handler)) {
            throw new \UnexpectedValueException('Event listener handler is not a valid callable');
        }
    }

    /**
     * @param \NucleusPhp\DataHub\Event\Event $event
     */
    public function handle(\NucleusPhp\DataHub\Event\Event $event)
    {
        if (!$this->handler) {
            return;
        }
        call_user_func($this->handler, $event);
    }

}