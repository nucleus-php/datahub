<?php

namespace NucleusPhp\DataHub\Job;

use NucleusPhp\DataHub\Job\Executor\ExecutorManager;

/**
 * Class Job
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class Job implements JobInterface
{

    const TYPE_STRING_SEPARATOR = '/';

    /**
     * @var string[]
     */
    private $type = [];

    /**
     * @var JobDataInterface
     */
    private $jobData;

    /**
     * @var bool
     */
    private $isExecuted = false;

    /**
     * Job constructor
     * @param string[] $jobType
     * @param array<null|bool|int|float|string|array> $jobData
     */
    public function __construct(array $jobType, array $jobData)
    {
        $this->type = $jobType;
        $this->jobData = new JobData($jobData);
    }

    /**
     */
    public function start()
    {
        if ($this->isExecuted()) {
            throw new \LogicException('Job was already executed');
        }
        $storedJobData = JobData::loadFromStorageForJob($this);
        $this->jobData->addData($storedJobData->getData());
        $this->getLogger()->info(sprintf('Job %s started', $this->getTypeAsString()));
    }

    /**
     */
    public function end()
    {
        $this->jobData->saveToStorageForJob($this);
        $this->isExecuted(true);
        $this->getLogger()->info(sprintf('Job %s ended', $this->getTypeAsString()));
    }

    /**
     * @return string[]
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTypeAsString()
    {
        return implode($this::TYPE_STRING_SEPARATOR, $this->type);
    }

    /**
     * @return JobDataInterface
     */
    public function getJobData()
    {
        return $this->jobData;
    }

    /**
     * @param bool|null $isExecuted
     * @return bool
     */
    public function isExecuted($isExecuted = null)
    {
        if (is_bool($isExecuted)) {
            $this->isExecuted = $isExecuted;
        }
        return $this->isExecuted;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     * @throws \Exception
     */
    public function getLogger()
    {
        return ExecutorManager::getLogger();
    }

}