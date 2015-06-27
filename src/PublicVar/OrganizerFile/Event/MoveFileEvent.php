<?php

namespace PublicVar\OrganizerFile\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Description of MoveFileEvent
 *
 * @author 
 */
class MoveFileEvent extends Event
{

    private $file;
    private $destination;

    public function __construct($file, $destination)
    {
        $this->file = $file;
        $this->destination = $destination;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getDestination()
    {
        return $this->destination;
    }


}
