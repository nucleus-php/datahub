<?php
/**
 * Add your job executors config file to your project's composer.json autoload files section:
 *
 * @example
 * {
 *     "autoload": {
 *         "files": ["config/job_executors.php"]
 *     }
 * }
 */

/**
 * Configure your Job Executors through the ExecutorManager
 *
 * @example
 * \NucleusPhp\DataHub\Job\Executor\ExecutorManager::addJobExecutor(
 *     'type/target/action',
 *     'executor_name',
 *      <callable|ExecutorInterface>
 * );
 *
 * @example
 * \NucleusPhp\DataHub\Job\Executor\ExecutorManager::addJobExecutors(
 *     'type/target/action',
 *     [
 *         'executor1_name' => <callable|ExecutorInterface>,
 *         'executor2_name' => <callable|ExecutorInterface>,
 *     ]
 * );
 */

use NucleusPhp\DataHub\Job\Executor\ExecutorManager;
use NucleusPhp\DataHub\Job\JobInterface;

ExecutorManager::addJobExecutor(
    'entity/test/batch',
    'test_batch',
    function (JobInterface $job) {
        var_dump($job);
    }
);
