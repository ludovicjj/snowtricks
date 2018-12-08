<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageDTO
{
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * ImageDTO constructor.
     * @param UploadedFile|null $file
     */
    public function __construct(
        UploadedFile $file = null
    )
    {
        $this->file = $file;
    }
}