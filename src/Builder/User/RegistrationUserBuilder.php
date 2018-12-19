<?php

namespace App\Builder\User;

use App\DTO\RegistrationDTO;
use App\Entity\Avatar;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationUserBuilder
{
    /**
     * @var User
     */
    private $user;

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

    /**
     * @param RegistrationDTO $registrationDTO
     * @return User
     * @throws \Exception
     */
    public function registration(RegistrationDTO $registrationDTO): User
    {
        $this->user = new User();
        $this->user->registrationUser(
            $registrationDTO->username,
            $this->passwordEncoder->encodePassword($this->user, $registrationDTO->password),
            $registrationDTO->email,
            new Avatar(
                'default-avatar.png',
                '/image/default-avatar.png',
                'avatar-default'
            )
        );

        return $this->user;
    }
}