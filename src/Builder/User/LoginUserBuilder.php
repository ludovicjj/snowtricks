<?php

namespace App\Builder\User;

use App\Repository\UserRepository;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class LoginUserBuilder extends AbstractFormLoginAuthenticator
{

    private $userRepository;
    private $passwordEncoder;
    private $router;
    private $csrfTokenManager;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'security_login'
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        // Array with $form->getData()
        $credentials = [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];

        // Define LAST_USERNAME
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['username']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // Validation du token
        $token = new CsrfToken('snowtricksauthentification', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException('Token invalide');
        }
        // Validation User
        $user = $this->userRepository->findOneBy(['username' => $credentials['username']]);
        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Mauvais identifiant.');
        } elseif (!$user->getEnabled()) {
            throw new CustomUserMessageAuthenticationException('Ce compte n\'est pas encore activé.');
        }
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // Validation password
        if (!$this->passwordEncoder->isPasswordValid($user, $credentials['password'])) {
            throw new CustomUserMessageAuthenticationException('Mot de passe incorrect.');
        }
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // Redirection a la page d'accueil
        return new RedirectResponse($this->router->generate('home'));
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('security_login');
    }
}