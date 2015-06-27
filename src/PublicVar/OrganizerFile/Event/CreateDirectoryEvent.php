<?php

namespace PublicVar\OrganizerFile\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Description of CreateDirectoryEvent
 *
 * @author 
 */
class CreateDirectoryEvent extends Event
{
    private $directory;
    
    public function __construct($directory)
    {
        $this->directory = $directory;
    }
    
    public function getDirectory()
    {
        return $this->directory;
    }


}
