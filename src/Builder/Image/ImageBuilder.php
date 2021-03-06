<?php

namespace App\Builder\Image;

use App\DTO\ImageDTO;
use App\Entity\Image;
use App\Service\FileUploader;

class ImageBuilder
{
    /**
     * @var FileUploader
     */
    private $fileUploader;

    public function __construct(
        FileUploader $fileUploader
    )
    {
        $this->fileUploader = $fileUploader;
    }

    /**
     * @param array $images
     * @return array
     * @throws \Exception
     */
    public function create(array $images)
    {
        $imagesCollection = [];

        foreach ($images as $image) {
            if (null !== $image) {
                $imagesCollection[] = $this->createImage($image);
            }
        }

        return $imagesCollection;
    }

    /**
     * @param ImageDTO $imageDTO
     * @return Image
     * @throws \Exception
     */
    public function createImage(ImageDTO $imageDTO)
    {
        $info =  $this->fileUploader->getImageInfo($imageDTO->file);

        return new Image(
            $info['filename'],
            $info['path'],
            $info['alt']
        );
    }
}