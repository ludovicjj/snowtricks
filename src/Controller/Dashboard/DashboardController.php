<?php

namespace App\Controller\Dashboard;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DashboardController
{
    /**
     * @var Environment
     */
    private $twig;
    private $urlGenerator;

    public function __construct(
        Environment $twig,
        UrlGeneratorInterface $urlGenerator

    )
    {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/compte", name="dashboard_home")
     *
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function dashboard(): Response
    {
        return new Response(
            //$this->urlGenerator->generate('dashboard_home')
            $this->twig->render('app/Dashboard/dashboard.html.twig')
        );
    }
}