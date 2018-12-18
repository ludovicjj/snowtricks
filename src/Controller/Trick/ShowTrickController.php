<?php

namespace App\Controller\Trick;

use App\Form\Handler\CommentHandler;
use App\Form\Type\CommentType;
use App\Repository\TrickRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class ShowTrickController
{
    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    private $commentHandler;

    public function __construct(
        TrickRepository $trickRepository,
        Environment $twig,
        FormFactoryInterface $formFactory,
        CommentHandler $commentHandler
    )
    {
        $this->trickRepository = $trickRepository;
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->commentHandler = $commentHandler;
    }

    /**
     * @Route("/figure/{slug}", name="show_trick")
     *
     * @param Request $request
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Exception
     */
    public function show(Request $request)
    {
        /* @var \App\Entity\Trick $trick */
        $trick = $this->trickRepository->findOneBy(['slug' => $request->attributes->get('slug')]);

        if (!$trick) {
            throw new NotFoundHttpException('Aucune figure ne correspond aux données reçu');
        }

        $form = $this->formFactory->create(CommentType::class)->handleRequest($request);
        $this->commentHandler->handle($form, $trick);

        return new Response(
            $this->twig->render('App/CRUD/show.html.twig', [
                'trick' => $trick,
                'form' => $form->createView(),
            ])
        );
    }
}