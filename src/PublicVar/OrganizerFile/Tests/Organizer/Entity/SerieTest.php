<?php
namespace PublicVar\OrganizerFile\Tests\Organizer\Entity;

use PublicVar\OrganizerFile\Organizer\Entity\Serie;

/**
 * Description of SerieTest
 *
 * @author 
 */
class SerieTest extends \PHPUnit_Framework_TestCase
{
    public function testGetNameSerie()
    {
        $serie = new Serie('Game.Of.Thrones.S05E07.VO.STFR.720p.mkv');
        $serieName = $serie->getName();
        $expected = 'Game Of Thrones';
        $this->assertEquals($expected, $serieName);
    }
    
    public function testGetSeason()
    {
        $serie = new Serie('Game.Of.Thrones.S05E07.VO.STFR.720p.mkv');
        $season = $serie->getSeason();
        $expected = 'S05';
        $this->assertEquals($expected, $season);
    }
}