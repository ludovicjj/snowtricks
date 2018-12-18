<?php

namespace App\Builder\Comment;

use App\DTO\CommentDTO;
use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommentBuilder
{
    /**
     * @var Comment
     */
    private $comment;

    /**
     * @var User
     */
    private $user;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorageInterface;

    public function __construct(
        TokenStorageInterface $tokenStorageInterface
    )
    {
        $this->tokenStorageInterface = $tokenStorageInterface;
    }

    public function getUser(): User
    {
        $this->user = $this->tokenStorageInterface->getToken()->getUser();

        return $this->user;
    }

    /**
     * @param CommentDTO $commentDTO
     * @param Trick $trick
     * @return Comment
     * @throws \Exception
     */
    public function createComment(CommentDTO $commentDTO, Trick $trick): Comment
    {
        $this->comment = new Comment(
            $commentDTO->message,
            $trick,
            $this->getUser()
        );

        return $this->comment;
    }
}