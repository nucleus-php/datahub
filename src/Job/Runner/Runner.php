<?php

namespace NucleusPhp\DataHub\Job\Runner;

use NucleusPhp\DataHub\Job\Job;
use NucleusPhp\DataHub\Job\Executor\ExecutorCollection;
use NucleusPhp\DataHub\Job\JobInterface;

/**
 * Class Runner
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class Runner
{

    /**
     * @var JobInterface
     */
    private $job;

    /**
     * @var ExecutorCollection
     */
    private $jobExecutorCollection;

    /**
     * Dispatcher constructor
     * @param JobInterface $job
     */
    public function __construct(JobInterface $job)
    {
        $this->job = $job;
    }

    public function dispatch()
    {
        $this->jobExecutorCollection = new ExecutorCollection();
        $this->jobExecutorCollection->handleForEvent($this->job);
    }

}