<?php

namespace PublicVar\OrganizerFile\Manipulator;
/**
 * Description of SystemManipulator
 *
 * @author 
 */
interface SystemManipulator
{
    //put your code here
    public function createDirectory($directory);
    
    public function moveFile($origine, $destination);
}
