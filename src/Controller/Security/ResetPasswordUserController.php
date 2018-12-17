<?php

namespace App\Controller\Security;

use App\Form\Handler\ResetPasswordHandler;
use App\Form\Type\ResetType;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class ResetPasswordUserController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var ResetPasswordHandler
     */
    private $resetPasswordHandler;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(
        UserRepository $userRepository,
        Environment $twig,
        FormFactoryInterface $formFactory,
        ResetPasswordHandler $resetPasswordHandler,
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->userRepository = $userRepository;
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->resetPasswordHandler = $resetPasswordHandler;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/reinitialiser/{token}", name="security_reset")
     *
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function reset(Request $request)
    {
        /* @var \App\Entity\User $user */
        $user = $this->userRepository->findOneBy(['token' => $request->attributes->get('token')]);

        if (!$user) {
            throw new NotFoundHttpException('Aucun utilisateur ne correspond a ce token');
        }

        $form = $this->formFactory->create(ResetType::class)->handleRequest($request);

        if ($this->resetPasswordHandler->handle($form, $user)) {

            return new RedirectResponse(
                $this->urlGenerator->generate('security_login')
            );
        }

        return new Response(
            $this->twig->render('app/Security/reset.html.twig', [
                'form' => $form->createView(),
            ])
        );
    }
}