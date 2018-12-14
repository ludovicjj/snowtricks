<?php

namespace App\Builder;

use App\Entity\Trick;
use App\DTO\TrickDTO;

class AddTrickBuilder
{
    private $imageBuilder;

    private $videoBuilder;

    public function __construct(
        ImageBuilder $imageBuilder,
        VideoBuilder $videoBuilder
    )
    {
        $this->imageBuilder = $imageBuilder;
        $this->videoBuilder = $videoBuilder;
    }

    /**
     * @param TrickDTO $trickDTO
     * @return Trick
     * @throws \Exception
     */
    public function create(TrickDTO $trickDTO): Trick
    {
        return new trick(
            $trickDTO->title,
            $trickDTO->description,
            $trickDTO->title,
            $trickDTO->category,
            $this->imageBuilder->create($trickDTO->images),
            $this->videoBuilder->create($trickDTO->videos)
        );
    }
}