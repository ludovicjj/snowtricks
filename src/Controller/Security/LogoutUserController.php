<?php

namespace App\Controller\Security;

use Symfony\Component\Routing\Annotation\Route;

class LogoutUserController
{
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
    }
}