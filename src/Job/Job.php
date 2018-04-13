<?php

namespace NucleusPhp\DataHub\Job;

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
        $storedJobData = JobData::loadFromStorageForJob($this);
        $this->jobData->addData($storedJobData->getData());
    }

    /**
     */
    public function end()
    {
        $this->jobData->saveToStorageForJob($this);
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

}