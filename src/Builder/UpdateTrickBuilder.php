<?php

namespace App\Builder;

use App\DTO\TrickDTO;
use App\Entity\Trick;

class UpdateTrickBuilder
{
    private $trick;

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
            $trickDTO->category
        );

        return $this->trick;
    }
}