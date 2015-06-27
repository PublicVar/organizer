<?php

namespace PublicVar\OrganizerFile\Console\Command;

use Exception;
use PublicVar\OrganizerFile\Event\SetDisplayerEvent;
use PublicVar\OrganizerFile\Manipulator\SymfonyFileManipulator;
use PublicVar\OrganizerFile\Manipulator\SymfonySystemManipulator;
use PublicVar\OrganizerFile\Organizer\SerieOrganizer;
use PublicVar\OrganizerFile\OrganizerEvents;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SerieOrganizerCommand extends Command
{
    private $eventDispatcher;

    public function __construct($name, $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct($name);
    }
    protected function configure()
    {
        $this
            
            ->setDescription('Re-organizing the series')
            ->addArgument(
                'directory', InputArgument::OPTIONAL, 'Directory to organize'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->eventDispatcher->dispatch(OrganizerEvents::SET_DISPLAYER, new SetDisplayerEvent($output));
        $directoryToOrganize = $input->getArgument('directory');
        
        //take the current directory to organize
        if(empty($directoryToOrganize)){
            $directoryToOrganize = getcwd();
        }
        
        $fileManipulator = new SymfonyFileManipulator();
        $serieOrganizer = new SerieOrganizer($directoryToOrganize, $this->eventDispatcher);
        $serieOrganizer->setFileManipulator($fileManipulator);
        
        if ($serieOrganizer->isDirectoryToOrganizeValid()) {
            $output->writeln('<info>Start organizing...</info>');

            $output->writeln('<info>Organizing : ' . $directoryToOrganize . '</info>');

        }

        try {
            
            $serieOrganizer->organize();
            
        } catch (Exception $exception) {
            $output->writeln('<error>' . $exception->getMessage() . '</error>');
        }

        $output->writeln('<info>End organizing.</info>');
    }

}
