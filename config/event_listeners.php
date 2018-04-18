<?php
/**
 * Add your event listeners config file to your project's composer.json autoload files section:
 *
 * @example
 * {
 *     "autoload": {
 *         "files": ["config/event_listeners.php"]
 *     }
 * }
 */

/**
 * Configure your Event Listeners through the ListenerManager
 *
 * @example
 * \NucleusPhp\DataHub\Event\Listener\ListenerManager::addEventListener(
 *     'type/target/event',
 *     'listener_name',
 *     <callable|ListenerInterface>
 * );
 *
 * @example
 * \NucleusPhp\DataHub\Event\Listener\ListenerManager::addEventListeners(
 *     'type/target/event',
 *     [
 *         'listener1_name' => <callable|ListenerInterface>,
 *         'listener2_name' => <callable|ListenerInterface>,
 *     ]
 * );
 */

use NucleusPhp\DataHub\Event\EventInterface;
use NucleusPhp\DataHub\Event\Listener\ListenerManager;

ListenerManager::addEventListener(
    'entity/test/new',
    'local_mysql_db',
    function(EventInterface $event) {
        var_dump($event);
    }
);
