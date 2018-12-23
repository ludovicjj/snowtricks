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
     * @var User
     */
    private $user;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * Comment constructor.
     * @param string $message
     * @param Trick $trick
     * @param User $user
     * @throws \Exception
     */
    public function __construct(
        string $message,
        Trick $trick,
        User $user
    )
    {
        $this->id = Uuid::uuid4();
        $this->message = $message;
        $this->trick = $trick;
        $this->user = $user;
        $this->createdAt = new \DateTime();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getTrick(): Trick
    {
        return $this->trick;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}