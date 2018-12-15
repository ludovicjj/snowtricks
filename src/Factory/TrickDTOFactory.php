<?php

namespace App\Factory;

use App\DTO\TrickDTO;
use App\Entity\Trick;

class TrickDTOFactory
{
    private $videoDTOFactory;

    public function __construct(
        VideoDTOFactory $videoDTOFactory
    )
    {
        $this->videoDTOFactory = $videoDTOFactory;
    }

    public function create(Trick $trick)
    {
        $videoDTO = [];

        foreach ($trick->getVideos() as $video) {
            $videoDTO[] = $this->videoDTOFactory->create($video);
        }

        return new TrickDTO(
            $trick->getTitle(),
            $trick->getDescription(),
            $trick->getCategory(),
            null,
            $videoDTO
        );
    }
}