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
    private $path;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $alt;

    /**
     * Image constructor.
     * @param string $path
     * @param string $filename
     * @param string $alt
     * @throws \Exception
     */
    public function __construct(
        string $path,
        string $filename,
        string $alt
    )
    {
        $this->id = Uuid::uuid4();
        $this->path = $path;
        $this->filename = $filename;
        $this->alt = $alt;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getAlt(): string
    {
        return $this->alt;
    }

    public function getWebPath(): string
    {
        return $this->path .'/'. $this->filename;
    }
}