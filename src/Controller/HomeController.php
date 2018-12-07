<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var TrickRepository
     */
    private $trickRepository;

    public function __construct(
        Environment $twig,
        TrickRepository $trickRepository
    )
    {
        $this->twig = $twig;
        $this->trickRepository = $trickRepository;
    }

    /**
     * @Route("/", name="home")
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function home(): Response
    {
        $tricks = $this->trickRepository->findAll();

        return new Response(
            $this->twig->render('app/home.html.twig', [
                'tricks' => $tricks
            ])
        );
    }
}