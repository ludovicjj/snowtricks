<?php

namespace App\Controller;

use App\DTO\TrickDTO;
use App\Repository\TrickRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Form\Type\UpdateTrickType;
use Twig\Environment;

class UpdateTrickController
{
    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(
        TrickRepository $trickRepository,
        FormFactoryInterface $formFactory,
        Environment $twig
    )
    {
        $this->trickRepository = $trickRepository;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
    }

    /**
     * @Route("/figure/modifier/{slug}", name="update_trick")
     * @param Request $request
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function update(Request $request): Response
    {
        /* @var \App\Entity\Trick $trick */
        $trick = $this->trickRepository->findOneBy(['slug' => $request->attributes->get('slug')]);

        if (!$trick) {
            throw new NotFoundHttpException('Aucune figure ne correspond aux données reçu');
        }

        $trickDTO = TrickDTO::updateTrickDTO($trick);

        $form = $this->formFactory->create(UpdateTrickType::class, $trickDTO)->handleRequest($request);

        return new Response(
            $this->twig->render('app/CRUD/update.html.twig', [
                'form' => $form->createView(),
            ])
        );
    }
}