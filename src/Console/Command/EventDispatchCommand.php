<?php

namespace NucleusPhp\DataHub\Console\Command;

use NucleusPhp\DataHub\Event\Dispatcher\Dispatcher as EventDispatcher;
use NucleusPhp\DataHub\Event\Event;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EventDispatchCommand
 *
 * @author Jochem Klaver <nucleus-php@7ochem.nl>
 */
class EventDispatchCommand extends Command
{

    /**
     */
    protected function configure()
    {
        $this->setName('event-dispatch');
        $this->setDescription('Dispatch an event.');
        $this->addArgument('event', InputArgument::REQUIRED, 'Event to dispatch.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $event = $input->getArgument('event');

        $output->writeln(sprintf(
            'Dispatching event: %s', $event
        ));

        $eventType = explode(Event::TYPE_STRING_SEPARATOR, $event);

        (new EventDispatcher(
            new Event($eventType)
        ))->dispatch();

        return 0;
    }

}