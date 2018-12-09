<?php

namespace App\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Image
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $imagePath;

    /**
     * @var string
     */
    private $imageName;

    /**
     * @var string
     */
    private $alt;

    /**
     * Image constructor.
     * @param string $imageName
     * @param string $imagePath
     * @param string $alt
     * @throws \Exception
     */
    public function __construct(
        string $imageName,
        string $imagePath,
        string $alt
    )
    {
        $this->id = Uuid::uuid4();
        $this->imageName = $imageName;
        $this->imagePath = $imagePath;
        $this->alt = $alt;
    }


    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getImageName(): string
    {
        return $this->imageName;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function getAlt(): string
    {
        return $this->alt;
    }
}