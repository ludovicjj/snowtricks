<?php

namespace App\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Comment
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $message;

    /**
     * @var Trick
     */
    private $trick;

    /**
     * Comment constructor.
     * @param string $message
     * @param Trick $trick
     * @throws \Exception
     */
    public function __construct(
        string $message,
        Trick $trick
    )
    {
        $this->id = Uuid::uuid4();
        $this->message = $message;
        $this->trick = $trick;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getTrick()
    {
        return $this->trick;
    }
}