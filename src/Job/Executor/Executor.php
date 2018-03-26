<?php

namespace NucleusPhp\DataHub\Job\Executor;

use NucleusPhp\DataHub\Job\JobInterface;

/**
 * Class Executor
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class Executor implements ExecutorInterface
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var callable
     */
    private $handler;

    /**
     * Executor constructor
     * @param string $name
     * @param callable $handlerCallable
     * @throws \UnexpectedValueException
     */
    public function __construct($name, $handlerCallable)
    {
        $this->name = $name;
        $this->handler = $handlerCallable;
        if (!is_callable($this->handler)) {
            throw new \UnexpectedValueException('Job executor handler is not a valid callable');
        }
    }

    /**
     * @param JobInterface $job
     */
    public function handle(JobInterface $job)
    {
        if (!$this->handler) {
            return;
        }
        call_user_func($this->handler, $job);
    }

}