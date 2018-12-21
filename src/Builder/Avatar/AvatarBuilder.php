<?php

namespace App\Builder\Avatar;


use App\DTO\AvatarDTO;
use App\Entity\Avatar;
use App\Service\FileUploader;

class AvatarBuilder
{
    /**
     * @var FileUploader
     */
    private $fileUploader;

    /**
     * AvatarBuilder constructor.
     * @param FileUploader $fileUploader
     */
    public function __construct(
        FileUploader $fileUploader
    )
    {
        $this->fileUploader = $fileUploader;
    }

    /**
     * @param AvatarDTO $avatarDTO
     * @return Avatar
     * @throws \Exception
     */
    public function updateAvatar(AvatarDTO $avatarDTO)
    {
        return $this->createAvatar($avatarDTO);
    }

    /**
     * @param AvatarDTO $avatarDTO
     * @return Avatar
     * @throws \Exception
     */
    public function createAvatar(AvatarDTO $avatarDTO)
    {
        $info =  $this->fileUploader->getImageInfo($avatarDTO->avatar);

        return new Avatar(
            $info['filename'],
            $info['path'],
            $info['alt']
        );
    }
}