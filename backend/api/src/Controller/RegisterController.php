<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsController]
class RegisterController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator
    ) {}

    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();
        dd($request);
        $em = $this->managerRegistry->getManager();

        $body = json_decode($request->getContent());
        
        $email = $body->email;
        $password = $body->password;
        $plainPassword = $body->plainPassword;
        

        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setEmail($email);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($hashedPassword);
        $errors = $this->validator->validate($user);

        if($password !== $plainPassword){
            $errors->add(new ConstraintViolation('Les mots de passe ne correspondent pas.', null, [], null, 'plainPassword', null));
        }
        if(strlen($password) < 8){
            $errors->add(new ConstraintViolation('Le mot de passe doit contenir au moins 8 caractères.', null, [], null, 'password', null));
        }
        if(count($errors) > 0){
            $errors = array_map(function($error){
                return [
                    "message" => $error->getMessage()
                ];
                
            }, iterator_to_array($errors));
            
            return new JsonResponse(['status' => 'error', 'errors' => $errors], 422);

        }
       
        $em->getRepository(User::class)->save($user, true);
       
        
        return new JsonResponse(['message' => 'Votre inscription a bien été effectué.', 'status' => 'success'], 201);
        
}
}