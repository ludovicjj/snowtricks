<?php

namespace App\Controller;

use App\Builder\DeleteTrickBuilder;
use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DeleteTrickController
{
    /**
     * @var TrickRepository
     */
    private $trickRepository;

    /**
     * @var DeleteTrickBuilder
     */
    private $deleteTrickBuilder;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(
        TrickRepository $trickRepository,
        DeleteTrickBuilder $deleteTrickBuilder,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->trickRepository = $trickRepository;
        $this->deleteTrickBuilder = $deleteTrickBuilder;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/figure/supprimer/{slug}", name="delete_trick")
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Request $request)
    {
        /* @var \App\Entity\Trick $trick */
        $trick = $this->trickRepository->findOneBy(['slug' => $request->attributes->get('slug')]);
        $submittedToken = $request->request->get('token');
        if (!$trick) {
            throw new NotFoundHttpException('Aucune figure ne correspond aux données reçu');
        }
        $this->deleteTrickBuilder->delete($trick, $submittedToken);

        return new RedirectResponse(
            $this->urlGenerator->generate('home')
        );
    }
}