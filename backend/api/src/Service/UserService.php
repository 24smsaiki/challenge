<?php

namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserService
{
    private $tokenStorage;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    
    public function getCurrent()
    {

        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return null;
        }
    
        $user = $token->getUser();
        
    
        return $user;
    }
}
    