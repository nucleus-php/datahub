<?php

namespace NucleusPhp\DataHub\Console\Command;

use NucleusPhp\DataHub\Job\Job;
use NucleusPhp\DataHub\Job\Runner\Runner as JobRunner;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class JobRunCommand
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class JobRunCommand extends Command
{

    /**
     */
    protected function configure()
    {
        $this->setName('job-run');
        $this->setDescription('Run a job.');
        $this->addArgument('job', InputArgument::REQUIRED, 'Job to run.');
        $this->addOption('param', 'p',
            InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'Job parameter data');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $job = $input->getArgument('job');

        $output->writeln(sprintf(
            'Running job: %s', $job
        ));

        $jobType = explode(Job::TYPE_STRING_SEPARATOR, $job);
        $jobData = $this->parseParamOption($input->getOption('param'));

        (new JobRunner(
            new Job($jobType, $jobData)
        ))->dispatch();

        return 0;
    }

    /**
     * @param string[] $paramOption
     * @return string[]
     */
    private function parseParamOption(array $paramOption)
    {
        $params = [];
        foreach ($paramOption as $i => $option) {
            if (false === strpos($option, '=')) {
                $key = $option;
                $value = true;
            } else {
                list($key, $value) = explode('=', $option, 2);
            }
            $params[$key] = $value;
        }
        return $params;
    }

}