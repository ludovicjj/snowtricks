<?php

namespace App\Form\Handler;

use App\Builder\User\ForgottenPasswordBuilder;
use App\Service\Mailer;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ForgottenPasswordHandler
{
    /**
     * @var ForgottenPasswordBuilder
     */
    private $forgottenPasswordBuilder;

    private $mailer;

    private $sessionInterface;

    public function __construct(
        ForgottenPasswordBuilder $forgottenPasswordBuilder,
        Mailer $mailer,
        SessionInterface $sessionInterface
    )
    {
        $this->forgottenPasswordBuilder = $forgottenPasswordBuilder;
        $this->mailer = $mailer;
        $this->sessionInterface = $sessionInterface;
    }

    /**
     * @param FormInterface $form
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function handle(FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->forgottenPasswordBuilder->forgotten($form->getData());

            if ($user) {
                $this->mailer->sendMail($user, 'Réinitialiser mot de passe', 'forgotten');
                $this->sessionInterface->getFlashBag()->add(
                    'success',
                    'Un e-mail vous a été envoyé pour réinitialiser votre mot de passe.'
                );

                return;
            }
            $this->sessionInterface->getFlashBag()->add(
                'warning',
                'Aucun utilisateur ne correspond à ce pseudo ou cette e-mail.'
            );
        }
    }
}