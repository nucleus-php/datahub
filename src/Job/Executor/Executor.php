<?php

namespace NucleusPhp\DataHub\Job\Executor;

/**
 * Class Executor
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class Executor
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
     * @param \NucleusPhp\DataHub\Job\Job $job
     */
    public function handle(\NucleusPhp\DataHub\Job\Job $job)
    {
        if (!$this->handler) {
            return;
        }
        call_user_func($this->handler, $job);
    }

}