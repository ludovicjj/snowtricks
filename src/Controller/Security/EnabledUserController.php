<?php

namespace App\Controller\Security;

use App\Builder\User\EnabledUserBuilder;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EnabledUserController
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EnabledUserBuilder
     */
    private $enabledUserBuilder;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        UserRepository $userRepository,
        EnabledUserBuilder $enabledUserBuilder
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->userRepository = $userRepository;
        $this->enabledUserBuilder = $enabledUserBuilder;
    }

    /**
     * @Route("/enabled/{token}", name="security_enabled")
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function enabled(Request $request): RedirectResponse
    {
        /* @var \App\Entity\User $user */
        $user = $this->userRepository->findOneBy(['token' => $request->attributes->get('token')]);

        if (!$user) {
            throw new NotFoundHttpException('Aucun utilisateur ne correspond a ce token');
        }

        $this->enabledUserBuilder->enabled($user);

        return new RedirectResponse(
            $this->urlGenerator->generate('security_login')
        );
    }
}