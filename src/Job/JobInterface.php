<?php

namespace NucleusPhp\DataHub\Job;

/**
 * Class Job
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
interface JobInterface
{

    /**
     */
    public function start();

    /**
     */
    public function end();

    /**
     * @param bool|null $isExecuted
     * @return bool
     */
    public function isExecuted($isExecuted = null);

    /**
     * @return string[]
     */
    public function getType();

    /**
     * @return string
     */
    public function getTypeAsString();

    /**
     * @return JobDataInterface
     */
    public function getJobData();

}