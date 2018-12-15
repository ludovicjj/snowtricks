<?php

namespace App\Builder;

use App\DTO\TrickDTO;
use App\Entity\Trick;

class UpdateTrickBuilder
{
    private $trick;

    private $imageBuilder;

    private $videoUpdateBuilder;

    public function __construct(
        ImageBuilder $imageBuilder,
        VideoUpdateBuilder $videoUpdateBuilder
    )
    {
        $this->imageBuilder = $imageBuilder;
        $this->videoUpdateBuilder = $videoUpdateBuilder;
    }

    /**
     * @param TrickDTO $trickDTO
     * @param Trick $trick
     * @return Trick
     * @throws \Exception
     */
    public function update(TrickDTO $trickDTO, Trick $trick): Trick
    {
        $this->trick = $trick;


        $this->trick->update(
            $trickDTO->title,
            $trickDTO->description,
            $trickDTO->title,
            $trickDTO->category,
            $this->imageBuilder->create($trickDTO->images),
            $this->videoUpdateBuilder->compare($trickDTO->videos, $trick->getVideos()->toArray())
        );

        return $this->trick;
    }
}