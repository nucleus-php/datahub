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
     * @var
     */
    private $jobData;

    /**
     * Job constructor
     * @param string[] $jobType
     * @param array $jobData
     */
    public function __construct(array $jobType, $jobData)
    {
        $this->type = $jobType;
        $this->jobData = $jobData;
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

}