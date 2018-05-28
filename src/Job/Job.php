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
    private $isDispatched = false;

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
        if ($this->isDispatched()) {
            throw new \LogicException('Job was already dispatched');
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
        $this->isDispatched(true);
        $this->logger->info(sprintf('Job %s ended', $this->getTypeAsString()));
    }

    /**
     * @param bool|null $isDispatched
     * @return bool
     */
    public function isDispatched($isDispatched = null)
    {
        if (is_bool($isDispatched)) {
            $this->isDispatched = $isDispatched;
        }
        return $this->isDispatched;
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
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

}