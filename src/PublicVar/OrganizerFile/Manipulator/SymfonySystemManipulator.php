<?php

namespace PublicVar\OrganizerFile\Manipulator;

use PublicVar\OrganizerFile\Event\DisplayInConsoleEvent;
use PublicVar\OrganizerFile\OrganizerEvents;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Process\Process;

/**
 * Description of SymfonySystemManipulator
 *
 * @author 
 */
class SymfonySystemManipulator implements SystemManipulator
{

    private $eventDispatcher;

    public function setEventDispatcher($eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        return $this;
    }

    private function display($message, $messageType='')
    {
        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch(OrganizerEvents::DISPLAY_IN_CONSOLE, new DisplayInConsoleEvent($message,$messageType));
        }
    }

    public function createDirectory($directory)
    {
        if (!empty($directory) && !is_dir($directory)) {
            $execCreateDirectory = 'mkdir -p "' . $directory . '"';
            $process = new Process($execCreateDirectory, null, null, null, null);
            $process->run(function ($type, $buffer) {
                if ('err' === $type) {
                    $this->display('create directory Error > ' . $buffer);
                }
                else {
                    $this->display('directory created > ' . $buffer);
                }
            });
        }
    }

    public function moveFile($origine, $destination)
    {
        
        //transform space in "\ " for the mv command
        $origine = str_replace(' ', '\ ', $origine);
        //transform () in "\(\)" for the mv command
        $origine = str_replace('(', '\(', $origine);
        $origine = str_replace(')', '\)', $origine);
        $destination = str_replace(' ', '\ ', $destination);
        $this->display('move file > ' . $origine,'comment');

        $execMoveFile = "mv -f $origine $destination";
        $process = new Process($execMoveFile, null, null, null, null);
        $process->run(function ($type, $buffer) {
  
            $this->display('move file');
            if ('err' === $type) {
                $this->display('move file error > ' . $buffer);
            }
            else {

                $this->display('file moved > ' . $buffer);
            }
        });
        //$process->run($this->runCallback);
    }

    public function runCallback($type, $buffer)
    {
       
        if ('err' === $type) {
            $this->display('move file error > ' . $buffer);
        }
        else {
            $this->display('move file > ' . $buffer);
        }
    }

    /**
     * 
     * @param string $directory
     * @param string $name
     * @return array of SplFileInfo
     */
    public function listFiles($directory, $name, $depth = '== 0')
    {
        $finder = new Finder();
        $finder->files()->name($name)
            ->in($directory)
            ->depth($depth)
        ;
        return iterator_to_array($finder);
    }

}
