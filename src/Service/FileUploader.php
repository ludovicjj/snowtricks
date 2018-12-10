<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploader
{
    private $imageDirectory;
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
        $imageDirectory,
        $imageUploadPath
    )
    {
        $this->imageDirectory = $imageDirectory;
        $this->imageUploadPath = $imageUploadPath;
    }

    public function getImageInfo(\SplFileInfo $file)
    {
        // class File extends SplFileInfo
        // class UploadedFile extends File

        $this->filename = md5(uniqid()).'.'.$file->guessExtension();

        // Chemin absolus:
        //$this->imagePath = $this->imageDirectory .'/'. $this->imageName;

        // Chemin relatif:
        $this->path = $this->imageUploadPath .'/'. $this->filename;
        $this->alt = strtolower(str_replace(' ', '-', $file->getClientOriginalName()));

        try {
            // Déplace l'image dans le repertoire '%kernel.project_dir%/public/uploads/images'
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