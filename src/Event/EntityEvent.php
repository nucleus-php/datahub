<?php

namespace NucleusPhp\DataHub\Event;

/**
 * Class EntityEvent
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class EntityEvent extends Event
{

    /**
     * @var object
     */
    private $entity;

    /**
     * EntityEvent constructor
     *
     * @param string[] $eventType
     * @param $entity
     */
    public function __construct($eventType, $entity)
    {
        array_unshift($eventType, 'entity');
        parent::__construct($eventType);
        $this->entity = $entity;
    }

    /**
     * @return object
     */
    public function getEntity()
    {
        return $this->entity;
    }

}