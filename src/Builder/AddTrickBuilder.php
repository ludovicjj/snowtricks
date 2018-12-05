<?php

namespace App\Builder;

use App\Entity\Trick;
use App\DTO\TrickDTO;

class AddTrickBuilder
{
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
            $trickDTO->title
        );
    }
}