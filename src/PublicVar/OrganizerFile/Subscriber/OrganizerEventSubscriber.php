<?php

namespace PublicVar\OrganizerFile\Subscriber;

use PublicVar\OrganizerFile\OrganizerEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Description of OrganizerEventSubscriber
 *
 * @author 
 */
class OrganizerEventSubscriber implements EventSubscriberInterface
{
    private $systemManipulator;
    private $displayer;
    
    static public function getSubscribedEvents()
    {
        return array(
            OrganizerEvents::CREATE_DIRECTORY => array('createDirectory', 0 ),
            OrganizerEvents::MOVE_FILE     => array('moveFile', 0),
            OrganizerEvents::DISPLAY_IN_CONSOLE => array('displayInConsole',0),
            OrganizerEvents::SET_DISPLAYER => array('setDisplayer',0),
        );
    }
    
    public function createDirectory($event){
        if($this->systemManipulator){
            $this->systemManipulator->createDirectory($event->getDirectory());
        }
    }
    
    public function moveFile($event){
        if($this->systemManipulator){
            $this->systemManipulator->moveFile($event->getFile(),$event->getDestination());
        }
    }
    
    public function displayInConsole($event){
        if($this->displayer){
            $message = $event->getMessage();
            $messageType = $event->getMessageType();
            switch ($messageType) {
                case 'info':
                    $message = '<info>'.$message.'</info>';
                    break;
                case 'comment':
                    $message = '<comment>'.$message.'</comment>';
                    break;
                case 'question':
                    $message = '<question>'.$message.'</question>';
                    break;
                case 'error':
                    $message = '<error>'.$message.'</error>';
                    break;

            }
            
            $this->displayer->writeln($message);
        }
    }


    public function setSystemManipulator($systemManipulator)
    {
        $this->systemManipulator = $systemManipulator;
        return $this;
    }
    
    public function setDisplayer($event)
    {
        $this->displayer = $event->getDisplayer();
    }


}
