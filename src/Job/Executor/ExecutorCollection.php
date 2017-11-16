<?php

namespace NucleusPhp\DataHub\Job\Executor;

use NucleusPhp\DataHub\Job\Job;

/**
 * Class ExecutorCollection
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class ExecutorCollection
{

    /**
     * @var Executor[][]
     */
    private $jobExecutors = [];

    /**
     * Collection constructor
     */
    public function __construct()
    {
        $config = require(ROOT_DIR . '/config/job_executors.php');
        foreach ($config as $jobType => $executorsList) {
            foreach ($executorsList as $executorName => $executorHandlerCallable) {
                $this->jobExecutors[$jobType][$executorName] = new Executor($executorName, $executorHandlerCallable);
            }
        }
    }

    /**
     * @param string $jobType
     * @return Executor[]
     */
    public function getExecutorsForType($jobType)
    {
        if (!array_key_exists($jobType, $this->jobExecutors)) {
            throw new \OutOfBoundsException('No job executors registered for this type of job');
        }
        return $this->jobExecutors[$jobType];
    }


    /**
     * @param Job $job
     */
    public function handleForEvent($job)
    {
        $executors = $this->getExecutorsForType($job->getTypeAsString());
        foreach ($executors as $executor) {
            $executor->handle($job);
        }
    }

}