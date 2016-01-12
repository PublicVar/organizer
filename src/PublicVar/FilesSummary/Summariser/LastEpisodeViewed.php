<?php

namespace PublicVar\FilesSummary\Summariser;

use Exception;
use PublicVar\FilesSummary\Event\AllEpisodeViewedEvent;
use PublicVar\FilesSummary\SummariserEvents;
use PublicVar\OrganizerFile\Organizer\Entity\Serie;

/**
 * Description of LastEpisodeViewed
 *
 * @author 
 */
class LastEpisodeViewed
{

    private $directoryToSearchIn;
    private $eventDispatcher;
    private $fileManipulator;
    private $lastEpisodeViewed;

    public function __construct($directoryToSearchIn, $eventDispatcher, $fileManipulator)
    {
        $this->directoryToSearchIn = $directoryToSearchIn;
        $this->eventDispatcher = $eventDispatcher;
        $this->fileManipulator = $fileManipulator;
        $this->lastEpisodeViewed = [];
    }

    public function summarize($directoryToSearchIn = '')
    {
        if (!empty($directoryToSearchIn)) {
            $this->directoryToSearchIn = $directoryToSearchIn;
        }

        if (!is_dir($this->directoryToSearchIn)) {
            throw new Exception('Directory to search in for listing all episodes viewed not valid : ' . $directoryToSearchIn);
        }

        $listVideosFiles = null;

        if ($this->fileManipulator) {
            $listVideosFiles = $this->fileManipulator->listFiles($this->directoryToSearchIn, '/\.(mkv|avi|mpg|mp4)$/', '> 0');
        }
        foreach ($listVideosFiles as $file) {
            $serie = new Serie($file->getFileName());
            $serieName = $serie->getName();
            if ($this->isSerie($serie)) {

                if (!isset($this->lastEpisodeViewed[$serieName])) {
                    $this->lastEpisodeViewed[$serieName] = array("season" => intval($serie->getSeason(true)), "episode" => intval($serie->getEpisode(true)));
                }
                else {
                    if (intval($serie->getSeason(true)) >= $this->lastEpisodeViewed[$serieName]['season'] && intval($serie->getEpisode(true)) > $this->lastEpisodeViewed[$serieName]['episode']) {
                        $this->lastEpisodeViewed[$serieName]['season'] = intval($serie->getSeason(true));
                        $this->lastEpisodeViewed[$serieName]['episode'] = intval($serie->getEpisode(true));
                    }
                }
            }
            $serie = null;
        }

        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch(SummariserEvents::LIST_ALL_EPISODES_VIEWED, new AllEpisodeViewedEvent($this->lastEpisodeViewed));
        }

        return $this->lastEpisodeViewed;
    }

    protected function isSerie($serie)
    {
        return $serie->getSeason() && $serie->getEpisode();
    }

    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    public function getFileManipulator()
    {
        return $this->fileManipulator;
    }

    public function setEventDispatcher($eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        return $this;
    }

    public function setFileManipulator($fileManipulator)
    {
        $this->fileManipulator = $fileManipulator;
        return $this;
    }

}
