<?php

namespace PublicVar\OrganizerFile\Tests\Organizer;

use PublicVar\OrganizerFile\Manipulator\SymfonyFileManipulator;
use PublicVar\OrganizerFile\Organizer\Entity\Serie;
use PublicVar\OrganizerFile\Organizer\SerieOrganizer;

/**
 * Description of SerieOrganizerTest
 *
 * @author 
 */
class SerieOrganizerTest extends \PHPUnit_Framework_TestCase
{

    public function testDirectoryToOrganizeIsValidInLinuxEnvironnement()
    {
        $serieOrganizer = new SerieOrganizer('/home');
        $this->assertTrue($serieOrganizer->isDirectoryToOrganizeValid());
    }

    public function testDirectoryToOrganizeIsNotValid()
    {
        $serieOrganizer = new SerieOrganizer('/fake-directory-public-var');
        $this->assertFalse($serieOrganizer->isDirectoryToOrganizeValid());
    }

    /**
     * @expectedException \PublicVar\OrganizerFile\Exception\DirectoryToOrganizeNotValidException
     */
    public function testOrganizeANotValidDirectoryException()
    {
        $serieOrganizer = new SerieOrganizer('/fake-directory-public-var');
        $serieOrganizer->organize();
    }

    public function testGetAllVideos()
    {
        $fileManipulator = $this->getMockBuilder('PublicVar\OrganizerFile\Manipulator\SymfonyFileManipulator')
            ->getMock();

        $serie1 = new Serie('Game.Of.Thrones.S05E07.VO.STFR.720p.mkv');
        $serie2 = new Serie('Game.Of.Thrones.S05E08.VO.STFR.720p.mkv');
        $filesFinding = array(
          $serie1, $serie2
        );
        $fileManipulator->expects($this->any())->method('listFiles')
            ->willReturn($filesFinding)

        ;

        $serieOrganizer = new SerieOrganizer('/home/nicolas/Vidéos/');
        $serieOrganizer->setFileManipulator($fileManipulator);
        $listFiles = $serieOrganizer->getAllVideos();
    
        $this->assertEquals($filesFinding, $listFiles);
    }

}
