<?php

namespace NucleusPhp\DataHub\Event;

/**
 * Class Event
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
interface EventInterface
{

    /**
     * @return string[]
     */
    public function getType();

    /**
     * @return string
     */
    public function getTypeAsString();

}