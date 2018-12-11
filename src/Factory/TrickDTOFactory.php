<?php

namespace App\Factory;

use App\DTO\TrickDTO;
use App\Entity\Trick;

class TrickDTOFactory
{
    public function create(Trick $trick)
    {

        return new TrickDTO(
            $trick->getTitle(),
            $trick->getDescription(),
            $trick->getCategory(),
            null
        );
    }
}