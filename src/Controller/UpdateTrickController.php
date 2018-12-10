<?php

namespace App\Controller;

use App\DTO\TrickDTO;
use App\Factory\TrickDTOFactory;
use App\Repository\TrickRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Form\Type\UpdateTrickType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;
use App\Form\Handler\UpdateTrickHandler;

class UpdateTrickController
{
    /**
     * @var TrickDTOFactory
     */
    private $trickDTOFactory;

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

    /**
     * @var UpdateTrickHandler
     */
    private $updateTrickHandler;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(
        TrickRepository $trickRepository,
        FormFactoryInterface $formFactory,
        Environment $twig,
        UpdateTrickHandler $updateTrickHandler,
        UrlGeneratorInterface $urlGenerator,
        TrickDTOFactory $trickDTOFactory
    )
    {
        $this->trickRepository = $trickRepository;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->updateTrickHandler= $updateTrickHandler;
        $this->urlGenerator = $urlGenerator;
        $this->trickDTOFactory = $trickDTOFactory;
    }

    /**
     * @Route("/figure/modifier/{slug}", name="update_trick")
     * @param Request $request
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Exception
     */
    public function update(Request $request): Response
    {
        // Recuperation d'un l'objet Trick par le slug
        /* @var \App\Entity\Trick $trick */
        $trick = $this->trickRepository->findOneBy(['slug' => $request->attributes->get('slug')]);

        // Vérification que l'objet recuperé à partir du slug n'est pas null
        if (!$trick) {
            throw new NotFoundHttpException('Aucune figure ne correspond aux données reçu');
        }

        // Hydratation du DTO avec les données de l'objet (remplace la méthode static)
        $trickDTO = $this->trickDTOFactory->create($trick);


        // Création du form avec trickDTO donc utilise "data_class" et plus "empty_data".
        // Le formulaire sera donc pré-rempli normalement.
        // UpdateTrickType est pour l'instant un simple extend de TrickType sans aucune modif.
        $form = $this->formFactory->create(UpdateTrickType::class, $trickDTO)->handleRequest($request);

        // Prise en charge du formulaire dans le handler
        if ($this->updateTrickHandler->handle($form, $trick)) {

            // Si formulaire valide, redirection vers la figure
            return new RedirectResponse(
                $this->urlGenerator->generate('show_trick', ['slug' => $trick->getSlug()])
            );
        }

        return new Response(
            $this->twig->render('app/CRUD/update.html.twig', [
                'form' => $form->createView(),
            ])
        );
    }
}