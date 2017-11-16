<?php

namespace NucleusPhp\DataHub\Job;

/**
 * Class EntityJob
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class EntityJob extends Job
{

    /**
     * EntityJob constructor
     *
     * @param string[] $jobType
     * @param array $jobData
     */
    public function __construct($jobType, $jobData)
    {
        array_unshift($jobType, 'entity');
        parent::__construct($jobType, $jobData);
    }

}