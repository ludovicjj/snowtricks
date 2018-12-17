<?php

namespace App\Builder\User;

use App\DTO\ForgottenDTO;
use App\Entity\User;
use App\Repository\UserRepository;

class ForgottenPasswordBuilder
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var User
     */
    private $user;

    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param ForgottenDTO $forgottenDTO
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function forgotten(ForgottenDTO $forgottenDTO)
    {
        $this->user = $this->userRepository->findUserByUsernameOrEmail($forgottenDTO->login);

        return $this->user;
    }
}