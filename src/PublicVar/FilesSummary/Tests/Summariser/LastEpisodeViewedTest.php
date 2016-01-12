<?php
namespace PublicVar\FilesSummary\Tests\Summariser;

use PublicVar\FilesSummary\Summariser\LastEpisodeViewed;
use PublicVar\OrganizerFile\Manipulator\SymfonyFileManipulator;
use PublicVar\OrganizerFile\Organizer\Entity\Serie;

/**
 * Description of SerieTest
 *
 * @author 
 */
class LastEpisodeViewedTest extends \PHPUnit_Framework_TestCase
{
    public function testGetNameSerie()
    {
        $fileManipulator = new SymfonyFileManipulator();
        $eventDispatch = $this->getMockBuilder('\\Symfony\\Component\\EventDispatcher\\EventDispatcher')
                     ->getMock();
        $lastEpisodeSummariser = new LastEpisodeViewed('/home/nicolas/Vidéos/Series',$eventDispatch,$fileManipulator);
        
        $listAllEpisodeViewed = $lastEpisodeSummariser->summarize();
        $expected = array(
          'Dominion'=>array('season'=>2,'episode'=>1),
          'Lucifer'=>array('season'=>1,'episode'=>1),
          'The 100'=>array('season'=>2,'episode'=>5),
        );
        
        $this->assertEquals($expected, $listAllEpisodeViewed);
    }
    
   
}