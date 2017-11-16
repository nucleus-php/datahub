<?php

/**
 * @todo Make this static calls to a class:
 * \NucleusPhp\DataHub\Event\Listener\Config::addEventListener(
 *     'type/target/event',
 *     'listener_name' => <callable>
 * );
 */

use NucleusPhp\DataHub\Event\EntityEvent;

return [
    'entity/test/new' => [
        'local_mysql_db' => function(EntityEvent $event) {
            var_dump($event);
        },
    ],
];
