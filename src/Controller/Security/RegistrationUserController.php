<?php

namespace App\Controller\Security;

use App\Form\Handler\RegistrationUserHandler;
use App\Form\Type\RegistrationType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class RegistrationUserController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var RegistrationUserHandler
     */
    private $registrationUserHandler;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(
        Environment $twig,
        FormFactoryInterface $formFactory,
        RegistrationUserHandler $registrationUserHandler,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->registrationUserHandler = $registrationUserHandler;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/inscription", name="security_registration")
     * @param Request $request
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Exception
     */
    public function registration(Request $request)
    {
        $form = $this->formFactory->create(RegistrationType::class)->handleRequest($request);

        if ($this->registrationUserHandler->handle($form)) {
            return new RedirectResponse(
                $this->urlGenerator->generate('security_login')
            );
        }

        return new Response(
            $this->twig->render('app/Security/registration.html.twig', [
                'form' => $form->createView(),
            ])
        );
    }
}