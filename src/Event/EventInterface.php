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

    /**
     * @param bool|null $isDispatched
     * @return bool
     */
    public function isDispatched($isDispatched = null);

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger();

}