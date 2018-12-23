<?php

namespace App\Form\Handler;

use App\Entity\Trick;
use App\Builder\Trick\UpdateTrickBuilder;
use App\Repository\TrickRepository;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UpdateTrickHandler
{
    /**
     * @var UpdateTrickBuilder
     */
    private $updateTrickBuilder;

    /**
     * @var ValidatorInterface
     */
    private $validatorInterface;

    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * @var SessionInterface
     */
    private $sessionInterface;

    /**
     * UpdateTrickHandler constructor.
     * @param UpdateTrickBuilder $updateTrickBuilder
     * @param ValidatorInterface $validatorInterface
     * @param TrickRepository $trickRepository
     * @param SessionInterface $sessionInterface
     */
    public function __construct(
        UpdateTrickBuilder $updateTrickBuilder,
        ValidatorInterface $validatorInterface,
        TrickRepository $trickRepository,
        SessionInterface $sessionInterface
    )
    {
        $this->updateTrickBuilder = $updateTrickBuilder;
        $this->validatorInterface = $validatorInterface;
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

            $trick = $this->updateTrickBuilder->update($form->getData(), $trick);

            $errors = $this->validatorInterface->validate($trick);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    if ($error->getPropertyPath() == 'title') {
                        $form->get('title')->addError(new FormError($error->getMessage()));
                    }
                    elseif ($error->getPropertyPath() == 'description') {
                        $form->get('description')->addError(new FormError($error->getMessage()));
                    }
                    elseif ($error->getPropertyPath() == 'category') {
                        $form->get('category')->addError(new FormError($error->getMessage()));
                    }
                }

                return false;
            }

            $this->trickRepository->save();
            $this->sessionInterface->getFlashBag()->add('success-update-trick', 'La figure a été modifiée avec succès');

            return true;
        }

        return false;
    }
}