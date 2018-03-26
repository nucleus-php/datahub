<?php

namespace NucleusPhp\DataHub\Job\Executor;

use NucleusPhp\DataHub\Job\JobInterface;

/**
 * Class ExecutorCollection
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class ExecutorCollection
{

    /**
     * @var ExecutorInterface[][]
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
     * @return ExecutorInterface[]
     */
    public function getExecutorsForType($jobType)
    {
        if (!array_key_exists($jobType, $this->jobExecutors)) {
            throw new \OutOfBoundsException('No job executors registered for this type of job');
        }
        return $this->jobExecutors[$jobType];
    }

    /**
     * @param JobInterface $job
     */
    public function handleForEvent(JobInterface $job)
    {
        $executors = $this->getExecutorsForType($job->getTypeAsString());
        foreach ($executors as $executor) {
            $executor->handle($job);
        }
    }

}