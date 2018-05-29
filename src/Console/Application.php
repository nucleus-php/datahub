<?php

namespace NucleusPhp\DataHub\Console;

use NucleusPhp\DataHub\Application as MainApplication;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application as SymfonyConsoleApplication;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class Application
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class Application extends MainApplication
{

    /**
     * @var SymfonyConsoleApplication
     */
    private $consoleApplication;

    /**
     */
    public function __construct()
    {
        parent::__construct();

        $this->consoleApplication = new SymfonyConsoleApplication($this->getName());
        $this->consoleApplication->add(new Command\EventDispatchCommand());
        $this->consoleApplication->add(new Command\JobRunCommand());
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        $input = new ArgvInput();
        $output = new ConsoleOutput();
        $logger = new \Symfony\Component\Console\Logger\ConsoleLogger($output);
        static::setLogger($logger);
        $this->consoleApplication->run($input, $output);
    }

}