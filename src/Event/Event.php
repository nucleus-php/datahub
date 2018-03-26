<?php

namespace NucleusPhp\DataHub\Event;

/**
 * Class Event
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class Event implements EventInterface
{

    const TYPE_STRING_SEPARATOR = '/';

    /**
     * @var string[]
     */
    private $type = [];

    /**
     * Event constructor
     * @param string[] $eventType
     */
    public function __construct(array $eventType)
    {
        $this->type = $eventType;
    }

    /**
     * @return string[]
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTypeAsString()
    {
        return implode($this::TYPE_STRING_SEPARATOR, $this->type);
    }

}