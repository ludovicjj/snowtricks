<?php

namespace App\Controller;

use App\Form\Handler\AddTrickHandler;
use App\Form\Type\AddTrickType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class AddTrickController
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
     * @var AddTrickHandler
     */
    private $addTrickHandler;

    public function __construct(
        Environment $twig,
        FormFactoryInterface $formFactory,
        AddTrickHandler $addTrickHandler
    )
    {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->addTrickHandler = $addTrickHandler;
    }

    /**
     * @Route("/figure/ajouter", name="add_trick")
     *
     * @param Request $request
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Exception
     */
    public function add(Request $request): Response
    {
        $form = $this->formFactory->create(AddTrickType::class)->handleRequest($request);

        $this->addTrickHandler->handle($form);

        return new Response(
            $this->twig->render('App/CRUD/add.html.twig', [
                'form' => $form->createView(),
            ])
        );
    }
}