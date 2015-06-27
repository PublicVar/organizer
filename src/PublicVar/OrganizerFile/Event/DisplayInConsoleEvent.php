<?php

namespace PublicVar\OrganizerFile\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Description of DisplayInConsoleEvent
 *
 * @author 
 */
class DisplayInConsoleEvent extends Event
{
    private $message;
    private $messageType;
    
    public function __construct($message, $messageType ='')
    {
        $this->message = $message;
        $this->messageType = $messageType;
    }
    
    public function getMessage()
    {
        return $this->message;
    }
    
    public function getMessageType()
    {
        return $this->messageType;
    }
}
