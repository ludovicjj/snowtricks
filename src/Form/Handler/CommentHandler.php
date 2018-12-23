<?php

namespace App\Form\Handler;

use App\Builder\Comment\CommentBuilder;
use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Component\Form\FormInterface;

class CommentHandler
{
    /**
     * @var CommentBuilder
     */
    private $commentBuilder;


    /**
     * @var TrickRepository
     */
    private $trickRepository;

    public function __construct(
        CommentBuilder $commentBuilder,
        TrickRepository $trickRepository
    )
    {
        $this->commentBuilder = $commentBuilder;
        $this->trickRepository = $trickRepository;
    }

    /**
     * @param FormInterface $form
     * @param Trick $trick
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function handle(FormInterface $form, Trick $trick): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $this->commentBuilder->createComment($form->getData(), $trick);

            if ($comment) {
                $trick->addComment($comment);
                // Incrémentation
                $trick->increaseComment();
                $this->trickRepository->save();
            }

            return true;
        }

        return false;
    }
}