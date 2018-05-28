<?php

namespace NucleusPhp\DataHub\Job\Runner;

use NucleusPhp\DataHub\Job\Executor\ExecutorManager;
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
     * @var ExecutorManager
     */
    private $jobExecutorManager;

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
        $this->job->start();
        $this->jobExecutorManager = new ExecutorManager();
        $this->jobExecutorManager->handleJob($this->job);
        $this->job->end();
    }

}