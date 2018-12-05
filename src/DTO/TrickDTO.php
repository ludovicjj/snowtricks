<?php

namespace App\DTO;


use App\Entity\Trick;

class TrickDTO
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    public $category;

    public static function updateTrickDTO(Trick $trick): self
    {
        $trickDTO = new self();
        $trickDTO->title = $trick->getTitle();
        $trickDTO->description = $trick->getDescription();
        $trickDTO->category = $trick->getCategory();

        return $trickDTO;
    }}