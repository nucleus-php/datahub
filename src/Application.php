<?php

namespace NucleusPhp\DataHub;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class Application
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private static $rootDir;

    /**
     * @var RequestInterface
     */
    private static $request;

    /**
     * @var ResponseInterface
     */
    private static $response;

    /**
     * @var LoggerInterface
     */
    private static $logger;

    /**
     * Application constructor
     */
    public function __construct()
    {
        $this->name = str_replace('\\', ' ', __NAMESPACE__);
    }

    /**
     * Run app
     */
    public function run()
    {
        // Run app
    }

    /**
     * Handle application request and build response
     */
    public function handle()
    {
        // Handle request
    }

    /**
     * Output response
     */
    public function output()
    {
        // Send output
    }

    /**
     * Handle application errors
     *
     * @param \Throwable $exception
     */
    public static function error(\Throwable $exception)
    {
        // Handle errors
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $rootDir
     */
    public static function setRootDir($rootDir)
    {
        if (!empty(self::$rootDir)) {
            throw new \RuntimeException('Application root dir was already set.');
        }
        self::$rootDir = $rootDir;
    }

    /**
     * @return string
     */
    public static function getRootDir()
    {
        if (empty(self::$rootDir)) {
            throw new \RuntimeException('Application root dir was not set.');
        }
        return self::$rootDir;
    }

    /**
     * @return RequestInterface
     */
    public static function getRequest()
    {
        if (!self::$request) {
            self::$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();
        }
        return self::$request;
    }

    /**
     * @return LoggerInterface
     * @throws \Exception
     */
    public static function getLogger()
    {
        if (!self::$logger) {
            self::$logger = new \Monolog\Logger('nucleus');
            self::$logger->pushHandler(
                new \Monolog\Handler\StreamHandler(static::getRootDir() . '/var/log/nucleus.log')
            );
        }

        return self::$logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    public static function setLogger(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }

}
