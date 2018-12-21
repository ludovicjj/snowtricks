<?php

namespace App\Form\Handler;

use App\Builder\Avatar\AvatarBuilder;
use App\Entity\User;
use App\Repository\AvatarRepository;
use App\Repository\UserRepository;
use App\Service\AvatarDelete;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AvatarHandler
{
    /**
     * @var AvatarBuilder
     */
    private $avatarBuilder;
    /**
     * @var AvatarDelete
     */
    private $avatarDelete;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var AvatarRepository
     */
    private $avatarRepository;
    private $sessionInterface;

    /**
     * AvatarHandler constructor.
     * @param AvatarBuilder $avatarBuilder
     * @param AvatarDelete $avatarDelete
     * @param UserRepository $userRepository
     * @param AvatarRepository $avatarRepository
     * @param SessionInterface $sessionInterface
     */
    public function __construct(
        AvatarBuilder $avatarBuilder,
        AvatarDelete $avatarDelete,
        UserRepository $userRepository,
        AvatarRepository $avatarRepository,
        SessionInterface $sessionInterface
    )
    {
        $this->avatarBuilder = $avatarBuilder;
        $this->avatarDelete = $avatarDelete;
        $this->userRepository = $userRepository;
        $this->avatarRepository = $avatarRepository;
        $this->sessionInterface = $sessionInterface;
    }

    /**
     * @param FormInterface $form
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function handler(FormInterface $form, User $user)
    {
        if ($form->isSubmitted() && $form->isValid())
        {
            //supprimer le fichier
            $oldAvatar = $user->getAvatar();
            $this->avatarDelete->delete($oldAvatar);


            //ajoute nouveau fichier dans le repertoir uploads/images
            $newAvatar = $this->avatarBuilder->updateAvatar($form->getData());
            $user->updateAvatar($newAvatar);

            //MAJ de la BDD
            $this->userRepository->save();
            $this->avatarRepository->remove($oldAvatar);

            //message flash
            $this->sessionInterface->getFlashBag()->add('success-avatar', 'L\'avatar a été modifié avec succès');

            return true;
        }

        return false;
    }
}