<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsController]
class ActivationUserController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
    ) {}

    /**
     * 
     *  @param string $token
    */

    public function __invoke(string $token)
    {
        $em = $this->managerRegistry->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['token' => $token]);
        if ($user->getToken() !== null) {
            
            $user->setToken(null);
            $user->setIsActif(true);
            $em->flush();
    
            return new JsonResponse(['message' => 'User correctly added', 'status' => 'success'], 201);
        } else {

            return new JsonResponse(['message' => 'Token expired', 'status' => 'success'], 201);
        }
    }
}
