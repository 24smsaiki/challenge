<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User || in_array("ROLE_ADMIN",$user->getRoles())) {
            return;
        }
        
        if (!$user->getIsActif()) {
            throw new CustomUserMessageAuthenticationException(
                'Veuillez activer votre compte avant de vous connecter.'
            );
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        // nothing to do here
    }
}
