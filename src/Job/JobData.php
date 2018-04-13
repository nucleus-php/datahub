<?php

namespace NucleusPhp\DataHub\Job;

/**
 * Class JobData
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class JobData implements JobDataInterface
{

    /**
     * @var array<null|bool|int|float|string|array>
     */
    private $jobData = [];

    /**
     * JobData constructor
     *
     * @param array<null|bool|int|float|string|array> $jobData
     */
    public function __construct(array $jobData)
    {
        $this->addData($jobData);
    }

    /**
     * @param Job $job
     * @return static
     */
    static public function loadFromStorageForJob(Job $job)
    {
        $jobData = [];
        $jobDataFile = static::generateTmpFileNameForJob($job);
        if (is_readable($jobDataFile)) {
            $jobData = json_decode(file_get_contents($jobDataFile), true);
        }
        return new static($jobData);
    }

    /**
     * @param Job $job
     * @return string
     */
    static private function generateTmpFileNameForJob(Job $job)
    {
        return sprintf(
            '/tmp/%s-%s.json',
            str_replace("\\", '-', strtolower(__NAMESPACE__)),
            md5($job->getTypeAsString())
        );
    }

    /**
     * @param Job $job
     */
    public function saveToStorageForJob(Job $job)
    {
        $jobDataFile = static::generateTmpFileNameForJob($job);
        file_put_contents($jobDataFile, $this->toJson());
    }

    /**
     * @param array<null|bool|int|float|string|array> $jobData
     */
    public function addData(array $jobData)
    {
        foreach ($jobData as $key => $value) {
            $this->add($key, $value);
        }
    }

    /**
     * @param int|string $key
     * @param null|bool|int|float|string|array $value
     */
    public function add($key, $value)
    {
        $this->addToDataContainer($key, $value, $this->jobData);
    }

    /**
     * Prevent complex types being added (and saved to storage)
     *
     * @param int|string $key
     * @param null|bool|int|float|string|array $value
     * @param array<null|bool|int|float|string|array> $container
     * @throws \UnexpectedValueException
     */
    private function addToDataContainer($key, $value, array &$container)
    {
        if (null === $value || is_scalar($value)) {
            $container[$key] = $value;
        } elseif (is_array($value)) {
            if (!array_key_exists($key, $container)) {
                $container[$key] = [];
            }
            foreach ($value as $subKey => $subValue) {
                $this->addToDataContainer($subKey, $subValue, $container[$key]);
            }
        } else {
            throw new \UnexpectedValueException(sprintf(
                'Job data is not allowed to be of type "%s" (for key "%s").',
                gettype($value), $key
            ));
        }
    }

    /**
     * @return array<null|bool|int|float|string|array>
     */
    public function getData()
    {
        return $this->jobData;
    }

    /**
     * @param int|string $key
     * @param null $defaultValue
     * @return null|bool|int|float|string|array
     */
    public function get($key, $defaultValue = null)
    {
        return (array_key_exists($key, $this->jobData) ? $this->jobData[$key] : $defaultValue);
    }

    /**
     * @param int|string $key
     */
    public function unset($key)
    {
        if (array_key_exists($key, $this->jobData)) {
            unset($this->jobData[$key]);
        }
    }

    /**
     * @return string
     */
    private function toJson()
    {
        return json_encode($this->jobData);
    }

}