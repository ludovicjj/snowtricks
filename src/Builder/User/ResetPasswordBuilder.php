<?php

namespace App\Builder\User;

use App\DTO\ResetDTO;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordBuilder
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function reset(ResetDTO $resetDTO, User $user)
    {
        $user->resetPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                $resetDTO->password
            )
        );
    }
}