<?php

namespace NucleusPhp\DataHub\Job;

use Psr\Log\LoggerInterface;

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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Job constructor
     * @param string[] $jobType
     * @param array<null|bool|int|float|string|array> $jobData
     * @param LoggerInterface $logger
     */
    public function __construct(array $jobType, array $jobData, LoggerInterface $logger)
    {
        $this->type = $jobType;
        $this->jobData = new JobData($jobData);
        $this->logger = $logger;
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
        $this->logger->info(sprintf('Job %s started', $this->getTypeAsString()));
    }

    /**
     */
    public function end()
    {
        $this->jobData->saveToStorageForJob($this);
        $this->isExecuted(true);
        $this->logger->info(sprintf('Job %s ended', $this->getTypeAsString()));
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
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

}