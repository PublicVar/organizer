<?php

namespace PublicVar\FilesSummary\Console\Command;

use Exception;
use PublicVar\FilesSummary\Summariser\LastEpisodeViewed;
use PublicVar\OrganizerFile\Event\SetDisplayerEvent;
use PublicVar\OrganizerFile\Manipulator\SymfonyFileManipulator;
use PublicVar\OrganizerFile\OrganizerEvents;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class LastEpisodeViewedCommand extends Command
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
            ->setDescription('List all last episode of all series in a text file')
            ->addArgument(
                'directory', InputArgument::OPTIONAL, 'Directory to organize'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->eventDispatcher->dispatch(OrganizerEvents::SET_DISPLAYER, new SetDisplayerEvent($output));
        $directoryToSearchIn = $input->getArgument('directory');

        //take the current directory to organize
        if (empty($directoryToSearchIn)) {
            $directoryToSearchIn = getcwd();
        }

        if (is_dir($directoryToSearchIn)) {
            $episodeViewedFileName = $directoryToSearchIn.'/episode_viewed.txt';
            $fileManipulator = new SymfonyFileManipulator();
            $lastEpisodeViewedSummariser = new LastEpisodeViewed($directoryToSearchIn, $this->eventDispatcher, $fileManipulator);

            $output->writeln("<info>Start searching ...</info>\n");

            
            try {

                $lastEpisodeViewed = $lastEpisodeViewedSummariser->summarize();
                
                if(!empty($lastEpisodeViewed)){
                    $fs = new Filesystem();
                    if(!file_exists($episodeViewedFileName)){
                        $fs->touch($episodeViewedFileName);
                    }
                    
                    $txtLastEpisodeViewed = '';
                    ksort($lastEpisodeViewed);
                    foreach($lastEpisodeViewed as $serieName => $serie){
                        $txtLastEpisodeViewed .= $serieName." S{$serie['season']} E{$serie['episode']} \n";
                    }
                    $fs->dumpFile($episodeViewedFileName, $txtLastEpisodeViewed);
                    
                    $output->writeln("$txtLastEpisodeViewed");
                }
                
            } catch (Exception $exception) {
                $output->writeln('<error>' . $exception->getMessage() . '</error>');
            }
            
              $output->writeln('<info>End</info>');

        }

    }

}
