<?php

namespace App\Form\Handler;

use App\Builder\User\RegistrationUserBuilder;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationUserHandler
{
    private $registrationUserBuilder;
    private $validatorInterface;
    private $mailer;
    private $sessionInterface;
    private $userRepository;


    public function __construct(
        RegistrationUserBuilder $registrationUserBuilder,
        ValidatorInterface $validatorInterface,
        Mailer $mailer,
        SessionInterface $sessionInterface,
        UserRepository $userRepository
    )
    {
        $this->registrationUserBuilder = $registrationUserBuilder;
        $this->validatorInterface = $validatorInterface;
        $this->mailer = $mailer;
        $this->sessionInterface = $sessionInterface;
        $this->userRepository = $userRepository;
    }

    /**
     * @param FormInterface $form
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Exception
     */
    public function handle(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid())
        {
            $user = $this->registrationUserBuilder->registration($form->getData());

            $errors = $this->validatorInterface->validate($user);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    if ($error->getPropertyPath() == 'username') {
                        $form->get('username')->addError(new FormError($error->getMessage()));
                    }
                    elseif ($error->getPropertyPath() == 'email') {
                        $form->get('email')->addError(new FormError($error->getMessage()));
                    }
                }

                return false;
            }
            $this->userRepository->persists($user);
            $this->mailer->sendMail($user, 'Inscription', 'registration');
            $this->sessionInterface->getFlashBag()->add(
                'success',
                ' Un email vous a été envoyé pour activer votre compte à l\'adresse suivant : '.$form->getData()->email
            );

            return true;
        }

        return false;
    }
}