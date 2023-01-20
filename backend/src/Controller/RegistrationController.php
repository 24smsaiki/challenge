<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class RegistrationController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();
        $em = $this->managerRegistry->getManager();

        $body = json_decode($request->getContent());
        
        $email = $body->email;
        $password = $body->password;
        $password2 = $body->password2;
        # check if email is empty
        if(!$email){
            return new JsonResponse(['message' => '"veuillez renseigner l\'email"', 'status' => 'error'], 422);
        }
        # check if user exists
        $existingUser = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if($existingUser){
            return new JsonResponse(['message' => 'Un compte existe déjà', 'status' => 'error'], 422);
        }
        #check if password equal to password2
        if($password != $password2){
            return new JsonResponse(['message' => 'Les mots de passes ne correspondent pas', 'status' => 'error'], 422);
        }                                                                                                                               
        
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );

        $user->setEmail($email);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($hashedPassword);
        $em->getRepository(User::class)->save($user, true);
        
        return new JsonResponse(['message' => 'utilisateur crée', 'status' => 'success'], 201);
        
}
}