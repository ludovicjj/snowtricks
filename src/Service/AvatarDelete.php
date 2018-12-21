<?php

namespace App\Service;

use App\Entity\Avatar;

class AvatarDelete
{
    /**
     * @var string
     */
    private $imageDirectory;

    public function __construct(
        string $imageDirectory
    )
    {
        $this->imageDirectory = $imageDirectory;
    }

    public function delete(Avatar $avatar)
    {
        $oldFile = $this->imageDirectory . '/' . $avatar->getFilename();

        if (file_exists($oldFile)) {
            unlink($oldFile);
        }
    }
}