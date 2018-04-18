<?php

namespace NucleusPhp\DataHub\Job\Executor;

use NucleusPhp\DataHub\Job\JobInterface;

/**
 * Class ExecutorManager
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class ExecutorManager
{

    /**
     * @var ExecutorInterface[][]
     */
    private static $jobExecutors = [];

    /**
     * @param string $jobType
     * @param string $executorName
     * @param callable|ExecutorInterface $executorHandlerCallable
     * @throws \UnexpectedValueException
     */
    public static function addJobExecutor($jobType, $executorName, callable $executorHandlerCallable)
    {
        if (!array_key_exists($jobType, static::$jobExecutors)) {
            static::$jobExecutors[$jobType] = [];
        } elseif (array_key_exists($executorName, static::$jobExecutors[$jobType])) {
            throw new \UnexpectedValueException(sprintf(
                'A job executor for job type "%s" with the name "%s" already exists',
                $jobType, $executorName
            ));
        }
        static::$jobExecutors[$jobType][$executorName] = (!$executorHandlerCallable instanceof ExecutorInterface
            ? new Executor($executorName, $executorHandlerCallable)
            : $executorHandlerCallable);
    }

    /**
     * @param string $jobType
     * @param array<string, callable|ExecutorInterface> $executors
     */
    public static function addJobExecutors($jobType, array $executors)
    {
        foreach ($executors as $executorName => $executorHandlerCallable) {
            static::addJobExecutor($jobType, $executorName, $executorHandlerCallable);
        }
    }

    /**
     * @param string $jobType
     * @return ExecutorInterface[]
     */
    public function getExecutorsForType($jobType)
    {
        if (!array_key_exists($jobType, static::$jobExecutors)) {
            throw new \OutOfBoundsException('No job executors registered for this type of job');
        }
        return static::$jobExecutors[$jobType];
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