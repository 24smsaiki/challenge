<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/all', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        $listUsers = array();
        foreach ($users as $user) {
            $listUsers[] = array(
                'id'     => $user->getId(),
                'email'    => $user->getEmail(),
                'roles' => $user->getRoles(),
            );
        }
        $reponse = new Response();
        $reponse->setContent(json_encode($listUsers));
        
        return $this->setResponseHeaders($reponse);;
        
    }
    #[Route('/register', name: 'registerNewUser', methods: ['POST'])]
    public function register(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher) : Response
    {
        $user = new User();

        $body = json_decode($request->getContent(), true);
        $email = $body['email'];
        $password = $body['password'];
        $password2 = $body['password2'];

        # check if email is empty
        if(isset($email)){
            return new Response('renseignez un email');
        }

        # check if user exists
        $existingUser = $userRepository->findOneBy(['email'=>$email]);
        if($existingUser)
        {
            return new Response('cet email existe déjà kemirawowooooo');
        }
        # check if password equal to password2
        if($password != $password2){
            return new Response('vérifier les password sont différents');
          
        }

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );
        
        $user->setEmail($email);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($hashedPassword);
        $userRepository->save($user, true);
        $response = new Response('added successfully');

        return $this->setResponseHeaders($response);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET','POST'])]
    public function new(Request $request, UserRepository $userRepository,UserPasswordHasherInterface $passwordHasher): Response
    {
        
        $user = new User();
        $body   = json_decode($request->getContent(), true);
        $email    = $body['email'];
        $password = $body['password'];
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );
        
        $user->setEmail($email);
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($hashedPassword);
        $userRepository->save($user, true);
        $reponse = new Response('added successfully');
        $reponse->headers->set("Content-Type", "application/json");
        $reponse->headers->set("Access-Control-Allow-Origin", "*");
     
        return $reponse;
       
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        $listUser[] = array(
            'id'     => $user->getId(),
            'email'    => $user->getEmail(),
            'roles' => $user->getRoles(),
        );
        
        $reponse = new Response();
        $reponse->setContent(json_encode($listUser));
        $reponse->headers->set("Content-Type", "application/json");
        $reponse->headers->set("Access-Control-Allow-Origin", "*");
        return $reponse;
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'PUT'])]
    public function edit(Request $request, User $user, UserRepository $userRepository,$id,UserPasswordHasherInterface $passwordHasher): Response
    {
        
        $user        = $userRepository->find($id);
        $body          = json_decode($request->getContent(), true);
        if ($body['email'] !== ''){
            
            $user->setEmail($body['email']);
        }
        if ($body['password'] !== ''){
            
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $body['password']
            );
            $user->setPassword($hashedPassword);
        }
        
        $userRepository->save($user, true);
        $reponse = new Response(json_encode(array(
                'email'    => $user->getEmail(),
                'password' => $user->getPassword()
                ))
        );
        $reponse->headers->set("Content-Type", "application/json");
        $reponse->headers->set("Access-Control-Allow-Origin", "*");
        return $reponse;
    }

    #[Route('/{id}/delete', name: 'app_user_delete', methods: ['DELETE'])]
    public function delete(User $user, UserRepository $userRepository): Response
    {
        $userRepository->remove($user,true);
        $reponse = new Response('removed successfully');
        $reponse->headers->set("Access-Control-Allow-Origin", "*");

        return $reponse;
    }




    # Add Private function here
    private function setResponseHeaders(Response $response) : Response
    {
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");
        return $response;   
    }
}
