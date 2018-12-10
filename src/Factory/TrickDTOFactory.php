<?php

namespace App\Factory;

use App\DTO\TrickDTO;
use App\Entity\Trick;

class TrickDTOFactory
{
    private $imageDTOFactory;

    public function __construct(
        ImageDTOFactory $imageDTOFactory
    )
    {
        $this->imageDTOFactory = $imageDTOFactory;
    }

    public function create(Trick $trick)
    {
        $images = $trick->getImages()->toArray();

        // init tableau vide
        $imageDTO = [];

        foreach ($images as $image) {
            $imageDTO [] = $this->imageDTOFactory->create($image);
        }

        return new TrickDTO(
            $trick->getTitle(),
            $trick->getDescription(),
            $trick->getCategory(),
            $imageDTO
        );
    }
}