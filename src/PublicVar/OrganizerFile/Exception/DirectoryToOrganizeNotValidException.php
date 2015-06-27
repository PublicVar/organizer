<?php

namespace PublicVar\OrganizerFile\Exception;

use Exception;

/**
 * Description of DirectoryToOrganizeNotValidException
 *
 * @author 
 */
class DirectoryToOrganizeNotValidException extends Exception
{

    public function __construct($directory = '', $code = 0, Exception $previous = null)
    {   
        $message = 'The directory to organize is not a valid one : '.$directory;

        parent::__construct($message, $code, $previous);
    }

    // chaîne personnalisée représentant l'objet
    public function __toString()
    {
        return __CLASS__ . ": {$this->message}\n";
    }

}
