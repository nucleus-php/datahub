<?php

namespace NucleusPhp\DataHub\Event\Listener;

use NucleusPhp\DataHub\Event\EventInterface;

/**
 * Class Listener
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
interface ListenerInterface
{

    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event);

}