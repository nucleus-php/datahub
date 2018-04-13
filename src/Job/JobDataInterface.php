<?php

namespace NucleusPhp\DataHub\Job;

/**
 * JobData Interface
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
interface JobDataInterface
{
    /**
     * @param Job $job
     * @return static
     */
    public static function loadFromStorageForJob(Job $job);

    /**
     * @param Job $job
     */
    public function saveToStorageForJob(Job $job);

    /**
     * @param array<null|bool|int|float|string|array> $jobData
     */
    public function addData(array $jobData);

    /**
     * @param int|string $key
     * @param null|bool|int|float|string|array $value
     */
    public function add($key, $value);

    /**
     * @return array<null|bool|int|float|string|array>
     */
    public function getData();

    /**
     * @param int|string $key
     * @param null $defaultValue
     * @return null|bool|int|float|string|array
     */
    public function get($key, $defaultValue = null);

    /**
     * @param int|string $key
     */
    public function unset($key);

}