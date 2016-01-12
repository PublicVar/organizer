<?php

namespace PublicVar\FilesSummary\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Description of CreateDirectoryEvent
 *
 * @author 
 */
class AllEpisodeViewedEvent extends Event
{
    private $listAllEpisodeViewed;
    
    public function __construct($listAllEpisodeViewed)
    {
        $this->listAllEpisodeViewed = $listAllEpisodeViewed;
    }

    public function getListAllEpisodeViewed()
    {
        return $this->listAllEpisodeViewed;
    }



}
