<?php

namespace App\Controller\Security;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

class LoginUserController
{
    private $twig;

    public function __construct(
        Environment $twig
    )
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/connexion", name="security_login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return new Response(
            $this->twig->render('app/security/login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error
            ])
        );
    }
}