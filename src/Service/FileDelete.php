<?php

namespace App\Service;

use App\Entity\Image;

class FileDelete
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

    public function delete(Image $image)
    {
        $oldFile = $this->imageDirectory . '/' . $image->getFilename();

        if (file_exists($oldFile)) {
            unlink($oldFile);
        }
    }
}