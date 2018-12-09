<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $imageDirectory;

    /**
     * @var string
     */
    private $imageName;

    /**
     * @var string
     */
    private $imagePath;

    /**
     * @var string
     */
    private $alt;

    public function __construct($imageDirectory)
    {
        $this->imageDirectory = $imageDirectory;
    }

    public function getImageInfo(UploadedFile $file)
    {
        $this->imageName = md5(uniqid()).'.'.$file->guessExtension();
        $this->imagePath = $this->imageDirectory .'/'. $this->imageName;
        $this->alt = strtolower(str_replace(' ', '-', $file->getClientOriginalName()));

        try {
            $file->move($this->imageDirectory, $this->imageName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }


        return [
            'imageName' => $this->imageName,
            'imagePath' => $this->imagePath,
            'alt' => $this->alt
        ];
    }
}