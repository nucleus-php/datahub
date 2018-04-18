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
     * @param bool|null $isDispatched
     * @return bool
     */
    public function isDispatched($isDispatched = null);

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