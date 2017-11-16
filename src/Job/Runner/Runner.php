<?php

namespace NucleusPhp\DataHub\Job\Runner;

use NucleusPhp\DataHub\Job\Job;
use NucleusPhp\DataHub\Job\Executor\ExecutorCollection;

/**
 * Class Runner
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class Runner
{

    /**
     * @var Job
     */
    private $job;

    /**
     * @var ExecutorCollection
     */
    private $jobExecutorCollection;

    /**
     * Dispatcher constructor
     * @param Job $job
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function dispatch()
    {
        $this->jobExecutorCollection = new ExecutorCollection();
        $this->jobExecutorCollection->handleForEvent($this->job);
    }

}