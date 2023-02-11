<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\MailService;
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
        private ValidatorInterface $validator,
        private MailService $mail
    ) {}

    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();
        $em = $this->managerRegistry->getManager();

        $body = json_decode($request->getContent());
        
        $email = $body->email;
        $password = $body->password;
        $passwordConfirmation = $body->passwordConfirmation;
        $role = "ROLE_USER";
        
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setFirstname($body->firstname);
        $user->setLastname($body->lastname);
        $user->setEmail($email);
        $user->setRoles([$role]);
        $user->setIsActif(false);

        $user->setIsPasswordRequest(false);
        $user->setPassword($hashedPassword);
        $user->setToken(bin2hex(random_bytes(32)));

        $errors = $this->validator->validate($user);

        if($password !== $passwordConfirmation){
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
        
        $content = "<h3>voici le lien d'activation de votre compte"." https://localhost/user/activation/".$user->getToken()."</h3>";
        $this->mail->send($email,'Activation de compte',$content);
        
        return new JsonResponse(['message' => "Un mail d'activation vient d'être envoyé à votre mail", 'status' => 'success'], 201);
        
}
}