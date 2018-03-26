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
     * @return string[]
     */
    public function getType();

    /**
     * @return string
     */
    public function getTypeAsString();

}