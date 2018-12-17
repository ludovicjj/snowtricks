<?php

namespace App\Form\Handler;

use App\Builder\User\ResetPasswordBuilder;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ResetPasswordHandler
{
    /**
     * @var ResetPasswordBuilder
     */
    private $resetPasswordBuilder;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var SessionInterface
     */
    private $sessionInterface;

    public function __construct(
        ResetPasswordBuilder $resetPasswordBuilder,
        UserRepository $userRepository,
        SessionInterface $sessionInterface
    )
    {
        $this->resetPasswordBuilder = $resetPasswordBuilder;
        $this->userRepository = $userRepository;
        $this->sessionInterface = $sessionInterface;
    }

    /**
     * @param FormInterface $form
     * @param User $user
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(FormInterface $form, User $user)
    {
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->resetPasswordBuilder->reset($form->getData(), $user);
            $this->userRepository->save();
            $this->sessionInterface->getFlashBag()->add(
                'reset-success',
                'Votre mot de passe a été réinitialisé.'
            );

            return true;
        }

        return false;
    }
}