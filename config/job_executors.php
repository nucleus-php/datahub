<?php

/**
 * @todo Make this static calls to a class:
 * \NucleusPhp\DataHub\Job\Executor\Config::addJobExecutor(
 *     'type/target/action',
 *     'executor_name' => <callable>
 * );
 */

use NucleusPhp\DataHub\Job\Job;

return [
    'entity/test/batch' => [
        'test_batch' => function($job) {
            var_dump($job);
        },
    ],
];