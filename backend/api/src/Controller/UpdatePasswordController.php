<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsController]
class UpdatePasswordController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    /**
     * 
     *  @param string $token
    */

    public function __invoke(string $token)
    {
        $em = $this->managerRegistry->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['token' => $token]);
        $request = $this->requestStack->getCurrentRequest();
        
        $newPassword = json_decode($request->getContent())->newPassword;
        $confirmPassword = json_decode($request->getContent())->confirmPassword;

        
        if ($newPassword === $confirmPassword) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $newPassword
            );
            $user->setToken(null);
            $user->setPassword($hashedPassword);
            $em->flush();
            
        }

        return $this->json("password updated");
    }
}
