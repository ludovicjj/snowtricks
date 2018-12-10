<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageDTO
{
    /**
     * @var \SplFileInfo
     */
    public $file;


    /**
     * ImageDTO constructor.
     * @param \SplFileInfo|null $file
     */
    public function __construct(
        \SplFileInfo $file = null
    )
    {
        $this->file = $file;
    }
}