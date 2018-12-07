<?php

namespace App\Builder;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

use App\Entity\Trick;

class DeleteTrickBuilder
{
    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfTokenManager;

    /**
     * @var SessionInterface
     */
    private $sessionInterface;

    /**
     * @var TrickRepository
     */
    private $trickRepository;

    public function __construct(
        CsrfTokenManagerInterface $csrfTokenManager,
        SessionInterface $sessionInterface,
        TrickRepository $trickRepository
    )
    {
        $this->csrfTokenManager = $csrfTokenManager;
        $this->sessionInterface = $sessionInterface;
        $this->trickRepository = $trickRepository;
    }

    /**
     * @param Trick $trick
     * @param string $submittedToken
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(
        Trick $trick,
        string $submittedToken
    )
    {
        if ($this->csrfTokenManager->isTokenValid(new CsrfToken('delete'.$trick->getId()->toString(), $submittedToken))) {
            $this->sessionInterface->getFlashBag()->add('success', 'La figure a été supprimée avec succès');
            $this->trickRepository->remove($trick);

            return true;
        } else {
            throw new InvalidCsrfTokenException('Le token est invalide.');
        }
    }
}