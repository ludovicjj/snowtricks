<?php

namespace App\Builder\Comment;

use App\DTO\CommentDTO;
use App\Entity\Comment;
use App\Entity\Trick;

class CommentBuilder
{
    /**
     * @var Comment
     */
    private $comment;

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
            $trick
        );

        return $this->comment;
    }
}