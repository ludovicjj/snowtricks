<?php

namespace App\Builder\User;

use App\Entity\User;
use App\Repository\UserRepository;

class EnabledUserBuilder
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function enabled(User $user)
    {
        if (!$user->getEnabled()) {
            $user->enabledUser(true);
            $this->userRepository->save();
        }
    }
}