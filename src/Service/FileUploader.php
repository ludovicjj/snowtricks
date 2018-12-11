<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploader
{
    /**
     * @var string
     */
    private $imageDirectory;

    /**
     * @var string
     */
    private $imageUploadPath;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $alt;

    public function __construct(
        string $imageDirectory,
        string $imageUploadPath
    )
    {
        $this->imageDirectory = $imageDirectory;
        $this->imageUploadPath = $imageUploadPath;
    }

    public function getImageInfo(\SplFileInfo $file)
    {
        $this->filename = md5(uniqid()).'.'.$file->guessExtension();
        $this->path = $this->imageUploadPath .'/'. $this->filename;
        $this->alt = strtolower(str_replace(' ', '-', $file->getClientOriginalName()));

        try {
            $file->move($this->imageDirectory, $this->filename);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return [
            'filename' => $this->filename,
            'path' => $this->path,
            'alt' => $this->alt
        ];
    }
}