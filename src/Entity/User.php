<?php

namespace App\Entity;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var string
     */
    private $token;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var Avatar
     */
    private $avatar;

    /**
     * User constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->roles = array('ROLE_USER');
        $this->token = hash("sha512", uniqid());
        $this->enabled = false;
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $email
     * @param Avatar $avatar
     */
    public function registrationUser(
        string $username,
        string $password,
        string $email,
        Avatar $avatar
    )
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->avatar = $avatar;
    }

    /**
     * @param bool $enabled
     */
    public function enabledUser(
        bool $enabled
    )
    {
        $this->enabled = $enabled;
    }

    /**
     * @param string $password
     */
    public function resetPassword(
        string $password
    )
    {
        $this->password = $password;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getSalt()
    {
        return null;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getAvatar(): Avatar
    {
        return $this->avatar;
    }

    public function eraseCredentials()
    {
    }
}