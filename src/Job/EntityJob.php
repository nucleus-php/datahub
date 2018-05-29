<?php

namespace NucleusPhp\DataHub\Job;

use Psr\Log\LoggerInterface;

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
     * @param array<null|bool|int|float|string|array> $jobData
     */
    public function __construct(array $jobType, array $jobData)
    {
        array_unshift($jobType, 'entity');
        parent::__construct($jobType, $jobData);
    }

}