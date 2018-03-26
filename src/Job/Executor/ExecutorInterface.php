<?php

namespace NucleusPhp\DataHub\Job\Executor;

use NucleusPhp\DataHub\Job\JobInterface;

/**
 * Class Executor
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
interface ExecutorInterface
{

    /**
     * @param JobInterface $job
     */
    public function handle(JobInterface $job);

}