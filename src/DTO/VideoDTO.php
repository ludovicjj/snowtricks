<?php

namespace App\DTO;

class VideoDTO
{
    /**
     * @var string
     */
    public $url;

    public function __construct(
        string $url = null
    )
    {
        $this->url = $url;
    }
}