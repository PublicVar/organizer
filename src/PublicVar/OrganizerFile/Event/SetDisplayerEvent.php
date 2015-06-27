<?php
namespace PublicVar\OrganizerFile\Event;

use Symfony\Component\EventDispatcher\Event;
/**
 * Description of SetDisplayerEvent
 *
 * @author 
 */
class SetDisplayerEvent extends Event
{
    private $displayer;
    
    public function __construct($displayer)
    {
        $this->displayer = $displayer;
    }
    
    public function getDisplayer()
    {
        return $this->displayer;
    }
}
