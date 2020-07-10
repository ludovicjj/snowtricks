<?php

namespace App\Controller\Image;


use App\DTO\AvatarDTO;
use App\Entity\User;
use App\Form\Handler\AvatarHandler;
use App\Form\Type\AvatarType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Environment;

class UpdateAvatarController
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var User
     */
    private $user;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorageInterface;
    /**
     * @var AvatarHandler
     */
    private $avatarHandler;

    public function __construct(
        FormFactoryInterface $formFactory,
        Environment $twig,
        UrlGeneratorInterface $urlGenerator,
        TokenStorageInterface $tokenStorageInterface,
        AvatarHandler $avatarHandler
    )
    {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
        $this->tokenStorageInterface = $tokenStorageInterface;
        $this->avatarHandler = $avatarHandler;
    }

    /**
     * @Route("/compte/avatar", name="update_avatar")
     * @param Request $request
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Exception
     */
    public function avatarUpdate(Request $request)
    {
        $avatarDTO = new AvatarDTO();

        $form = $this->formFactory->create(AvatarType::class, $avatarDTO, array(
            'action' => $this->urlGenerator->generate($request->get('_route'))
        ))
            ->handleRequest($request)
        ;

        $this->user = $this->tokenStorageInterface->getToken()->getUser();


        if ($this->avatarHandler->handler($form, $this->user)) {
            return new Response('success');
        }

        return new Response(
            $this->twig->render('app/Dashboard/_create.html.twig', [
                'form' => $form->createView(),
            ])
        );

    }
}