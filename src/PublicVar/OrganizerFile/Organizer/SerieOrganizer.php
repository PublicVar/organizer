<?php

namespace PublicVar\OrganizerFile\Organizer;

use PublicVar\OrganizerFile\Event\CreateDirectoryEvent;
use PublicVar\OrganizerFile\Event\MoveFileEvent;
use PublicVar\OrganizerFile\Exception\DirectoryToOrganizeNotValidException;
use PublicVar\OrganizerFile\Manipulator\FileManipulator;
use PublicVar\OrganizerFile\Manipulator\SystemManipulator;
use PublicVar\OrganizerFile\Organizer\Entity\Serie;
use PublicVar\OrganizerFile\OrganizerEvents;
use Symfony\Component\Process\Process;

/**
 * Organize the series
 *
 * @author 
 */
class SerieOrganizer
{

    private $directoryToOrganize;
    private $fileManipulator;
    private $systemManipulator;
    private $output;
    private $eventDispatcher;

    public function __construct($directoryToOrganize, $eventDispatcher)
    {
        $this->directoryToOrganize = $directoryToOrganize;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * 
     * @return boolean true if $directoryToOrganize is a valid directory false otherwise
     */
    public function isDirectoryToOrganizeValid()
    {
        return is_dir($this->directoryToOrganize);
    }

    /**
     * Organize the videos in the directory
     * 
     * @throws DirectoryToOrganizeNotValidException
     */
    public function organize()
    {
        if (!$this->isDirectoryToOrganizeValid()) {
            throw new DirectoryToOrganizeNotValidException($this->directoryToOrganize);
        }

        $series = $this->getAllVideos();
        foreach ($series as $serie) {
            //if there is no season it not a serie :)
            if($serie->getSeason() != ''){
                $state = $this->moveFile($serie);
                $this->display($state);
            }
        }
    }

    private function moveFile($serie)
    {
        $fileName = $serie->getFileName();
        $serieName = $serie->getName();
        $season = $serie->getSeason() . '/';

        if (!empty($fileName) && !empty($serieName)) {
            $destinationDirectory = $this->getDirectoryToOrganize() . "/" . $serieName . "/" . $season;
            $originFile = $this->getDirectoryToOrganize() . "/" . $fileName;
            $this->eventDispatcher->dispatch(OrganizerEvents::CREATE_DIRECTORY, new CreateDirectoryEvent($destinationDirectory));
            $this->eventDispatcher->dispatch(OrganizerEvents::MOVE_FILE, new MoveFileEvent($originFile, $destinationDirectory));


            if($this->systemManipulator){
                return $this->systemManipulator->moveFile($originFile, $destinationDirectory);
            }
        }

        return '';
    }

    private function display($message){
        if($this->output){
            $this->output->writeln('<info>'.$message.'</info>');
        }
    }

    /**
     * get all videos in the directory
     * 
     * @return array list of the \PublicVar\OrganizerFile\Organizer\Entity\Serie
     */
    public function getAllVideos()
    {
        $listVideosFiles = [];

        if ($this->fileManipulator) {
            $listVideosFiles = $this->fileManipulator->listFiles($this->directoryToOrganize, '/\.(mkv|avi|mpg|mp4)$/');
        }

        $series = [];
        foreach ($listVideosFiles as $file) {
            $series[] = new Serie($file->getFileName());
        }
        return $series;
    }

    /**
     * Getter fileManipulator
     * 
     * @return FileManipulator
     */
    public function getFileManipulator()
    {
        return $this->fileManipulator;
    }

    /**
     * Setter file manipulator
     * 
     * @param FileManipulator $fileManipulator
     * @return SerieOrganizer
     */
    public function setFileManipulator(FileManipulator $fileManipulator)
    {
        $this->fileManipulator = $fileManipulator;

        return $this;
    }

    public function getSystemManipulator()
    {
        return $this->systemManipulator;
    }

    public function setSystemManipulator(SystemManipulator $systemManipulator)
    {
        $this->systemManipulator = $systemManipulator;
        return $this;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput($output)
    {
        $this->output = $output;
        return $this;
    }

    public function getDirectoryToOrganize()
    {
        if(substr($this->directoryToOrganize, -1) == "/"){
            return substr($this->directoryToOrganize, 0, -1);
        }
        return $this->directoryToOrganize;
    }





}
