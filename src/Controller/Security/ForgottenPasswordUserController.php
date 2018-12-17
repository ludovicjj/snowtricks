<?php

namespace App\Controller\Security;

use App\Form\Handler\ForgottenPasswordHandler;
use App\Form\Type\ForgottenType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ForgottenPasswordUserController
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
     * @var ForgottenPasswordHandler
     */
    private $forgottenPasswordHandler;

    public function __construct(
        Environment $twig,
        FormFactoryInterface $formFactory,
        ForgottenPasswordHandler $forgottenPasswordHandler
    )
    {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->forgottenPasswordHandler = $forgottenPasswordHandler;
    }

    /**
     * @Route("/password", name="security_forgotten")
     *
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function forgotten(Request $request)
    {
        $form = $this->formFactory->create(ForgottenType::class)->handleRequest($request);

        $this->forgottenPasswordHandler->handle($form);

        return new Response(
            $this->twig->render('app/Security/forgotten.html.twig',[
                'form' => $form->createView(),
            ])
        );
    }
}