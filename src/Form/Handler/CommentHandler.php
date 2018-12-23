<?php

namespace App\Form\Handler;

use App\Builder\Comment\CommentBuilder;
use App\Entity\Trick;
use App\Repository\TrickRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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

    /**
     * @var SessionInterface
     */
    private $sessionInterface;

    public function __construct(
        CommentBuilder $commentBuilder,
        TrickRepository $trickRepository,
        SessionInterface $sessionInterface
    )
    {
        $this->commentBuilder = $commentBuilder;
        $this->trickRepository = $trickRepository;
        $this->sessionInterface = $sessionInterface;
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

                // Message Flash
                $this->sessionInterface->getFlashBag()->add('success-comment', 'Votre commentaire a été rajouté avec succès');

                $this->trickRepository->save();
            }

            return true;
        }

        return false;
    }
}