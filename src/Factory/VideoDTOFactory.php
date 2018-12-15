<?php

namespace App\Factory;

use App\DTO\VideoDTO;
use App\Entity\Video;

class VideoDTOFactory
{
    /**
     * @param Video $video
     * @return VideoDTO
     */
    public function create(Video $video): VideoDTO
    {
        return new VideoDTO(
            $video->getUrl()
        );
    }
}