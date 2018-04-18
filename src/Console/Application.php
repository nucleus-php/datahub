<?php

namespace NucleusPhp\DataHub\Console;

use Symfony\Component\Console\Application as SymfonyConsoleApplication;

/**
 * Class Application
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class Application extends SymfonyConsoleApplication
{

    /**
     * @param string $name
     * @param string $version
     */
    public function __construct(string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
        if ($name === 'UNKNOWN') {
            $name = str_replace('\\', ' ', __NAMESPACE__);
        }
        if ($version === 'UNKNOWN') {
            $version = '0.1.0';
        }
        parent::__construct($name, $version);
    }

    /**
     * Override to use a custom List command
     *
     * @return \Symfony\Component\Console\Command\Command[] An array of default Command instances
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();

        foreach ($defaultCommands as $i => $defaultCommand) {
            /**
             * @todo Create \NucleusPhp\DataHub\Console\Command\ListCommand to add listing of registered events and jobs
             */
            $localCommandOverrideClassName = sprintf(
                '\\%s\\Command\\%s',
                __NAMESPACE__,
                array_reverse(explode('\\', get_class($defaultCommand)))[0]
            );
            if (class_exists($localCommandOverrideClassName)) {
                $defaultCommands[$i] = new $localCommandOverrideClassName();
            }
        }

        return $defaultCommands;
    }

}