<?php

namespace App\Form\Handler;

use App\Builder\Comment\CommentBuilder;
use App\Entity\Trick;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use Symfony\Component\Form\FormInterface;

class CommentHandler
{
    /**
     * @var CommentBuilder
     */
    private $commentBuilder;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    private $trickRepository;

    public function __construct(
        CommentBuilder $commentBuilder,
        CommentRepository $commentRepository,
        TrickRepository $trickRepository
    )
    {
        $this->commentBuilder = $commentBuilder;
        $this->commentRepository = $commentRepository;
        $this->trickRepository = $trickRepository;
    }

    /**
     * @param FormInterface $form
     * @param Trick $trick
     * @throws \Exception
     */
    public function handle(FormInterface $form, Trick $trick)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $this->commentBuilder->createComment($form->getData(), $trick);

            if ($comment) {
                $trick->addComment($comment);
                $this->trickRepository->save();
            }
        }
    }
}