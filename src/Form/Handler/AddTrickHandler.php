<?php

namespace App\Form\Handler;

use App\Builder\AddTrickBuilder;
use App\Repository\TrickRepository;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddTrickHandler
{
    /**
     * @var AddTrickBuilder
     */
    private $addTrickBuilder;

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

    public function __construct(
        AddTrickBuilder $addTrickBuilder,
        ValidatorInterface $validatorInterface,
        TrickRepository $trickRepository,
        SessionInterface $sessionInterface
    )
    {
        $this->addTrickBuilder = $addTrickBuilder;
        $this->validatorInterface = $validatorInterface;
        $this->trickRepository = $trickRepository;
        $this->sessionInterface = $sessionInterface;
    }

    /**
     * @param FormInterface $form
     * @return bool
     * @throws \Exception
     */
    public function handle(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {

            $trick = $this->addTrickBuilder->create($form->getData());

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

            $this->trickRepository->persits($trick);
            $this->sessionInterface->getFlashBag()->add('success', 'La figure a été rajouté avec succès');

            return true;
        }

        return false;
    }
}