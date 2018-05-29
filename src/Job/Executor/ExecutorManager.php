<?php

namespace NucleusPhp\DataHub\Job\Executor;

use NucleusPhp\DataHub\Application;
use NucleusPhp\DataHub\Job\JobInterface;

use Psr\Log\LoggerInterface;

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
        if (!array_key_exists($jobType, self::$jobExecutors)) {
            self::$jobExecutors[$jobType] = [];
        } elseif (array_key_exists($executorName, self::$jobExecutors[$jobType])) {
            throw new \UnexpectedValueException(sprintf(
                'A job executor for job type "%s" with the name "%s" already exists',
                $jobType, $executorName
            ));
        }
        self::$jobExecutors[$jobType][$executorName] = (!$executorHandlerCallable instanceof ExecutorInterface
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
        if (!array_key_exists($jobType, self::$jobExecutors)) {
            throw new \OutOfBoundsException('No job executors registered for this type of job');
        }
        return self::$jobExecutors[$jobType];
    }

    /**
     * @param JobInterface $job
     */
    public function handleJob(JobInterface $job)
    {
        $executors = $this->getExecutorsForType($job->getTypeAsString());
        foreach ($executors as $executor) {
            $executor->handle($job);
        }
    }

    /**
     * @return LoggerInterface
     * @throws \Exception
     */
    public static function getLogger()
    {
        return Application::getLogger();
    }

}