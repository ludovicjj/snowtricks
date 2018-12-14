<?php

namespace App\Builder;

use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Service\FileDelete;
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

    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * @var FileDelete
     */
    private $fileDelete;

    public function __construct(
        CsrfTokenManagerInterface $csrfTokenManager,
        SessionInterface $sessionInterface,
        TrickRepository $trickRepository,
        ImageRepository $imageRepository,
        FileDelete $fileDelete
    )
    {
        $this->csrfTokenManager = $csrfTokenManager;
        $this->sessionInterface = $sessionInterface;
        $this->trickRepository = $trickRepository;
        $this->imageRepository = $imageRepository;
        $this->fileDelete = $fileDelete;
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

//            foreach ($trick->getImages() as $image) {
//                // Supprime l'image
//                $this->fileDelete->delete($image);
//                // Clean table d'assosiation "tricks_images
//                $trick->removeImage($image);
//                // Cascade n'impacte pas la table "image"
//                // Clean la table image
//                $this->imageRepository->remove($image);
//            }
            // supprime les images
            foreach ($trick->getImages() as $image) {
                $this->fileDelete->delete($image);
            }
            $this->trickRepository->remove($trick);

            return true;
        } else {
            throw new InvalidCsrfTokenException('Le token est invalide.');
        }
    }
}