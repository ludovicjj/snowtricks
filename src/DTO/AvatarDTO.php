<?php

namespace App\DTO;


class AvatarDTO
{
    /**
     * @var \SplFileInfo
     */
    public $avatar;

    /**
     * AvatarDTO constructor.
     * @param \SplFileInfo|null $avatar
     */
    public function __construct(
        \SplFileInfo $avatar = null
    )
    {
        $this->avatar = $avatar;
    }
}