<?php

namespace PublicVar\OrganizerFile\Manipulator;

use Symfony\Component\Finder\Finder;

/**
 * Description of SymfonyFileManipulator
 *
 * @author 
 */
class SymfonyFileManipulator implements FileManipulator
{

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
