<?php

namespace PublicVar\OrganizerFile\Organizer\Entity;

/**
 * Description of Serie
 *
 * @author 
 */
class Serie
{
    
    private $file;

    public function __construct($file)
    {
        $this->file = $file;

    }
    
    public function getName()
    {
        $cleanName = $this->clean($this->file);
        $cleanName = preg_replace("/s[0-9]{2}\.* *e[0-9]{2}.+(mkv|avi|mp4|mpg)$/i", " ", $cleanName);
        $cleanName = trim($cleanName);
        $cleanName = ucwords($cleanName);
        return $cleanName;
    }
    
    public function getSeason($removeS=false)
    {
        preg_match("/s[0-9]{2}\.* *e[0-9]{2}/i", $this->file,$seasonAndEpisode);
        if(!empty($seasonAndEpisode[0])){
            preg_match("/s[0-9]{2}/i", $seasonAndEpisode[0],$season);
            if($removeS){
                $season[0] = substr($season[0],1);
            }
            return trim(strtoupper($season[0]));
            
        }
        return "";
    }
    
    public function getEpisode($removeE=false){
        preg_match("/s[0-9]{2}\.* *e[0-9]{2}/i", $this->file,$seasonAndEpisode);
        if(!empty($seasonAndEpisode[0])){
            preg_match("/e[0-9]{2}/i", $seasonAndEpisode[0],$episode);
            if($removeE){
                $episode[0] = substr($episode[0],1);
            }
            return trim(strtoupper($episode[0]));
            
        }
        return ""; 
    }
    
    public function getFileName()
    {
        return $this->file;
    }
    
    private function clean($videoName)
    {
        return preg_replace('/[^a-z0-9]+/i', ' ', $videoName);
    }

}
