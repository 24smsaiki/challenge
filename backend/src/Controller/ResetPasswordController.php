<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\ResetPassword;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/reset/password', name: 'app_reset_password')]
    public function index(Request $request): Response
    {
        $body = json_decode($request->getContent(),true);

        if ($body['email']) {
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($body['email']);

            if ($user) {
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new DateTime());
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();
                
                return new Response("reset password request successfully sent");
                //TODO mail
            } else {
               return new Response("email not exist in database");
            }
        }

    }

    #[Route('/update/password/{token}', name: 'app_update_password')]
    public function update(Request $request,$token,UserPasswordHasherInterface $encoder): Response
    {
        $now = new \DateTime();
        $resetPassword = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);
        $body = json_decode($request->getContent(),true);


        if ($now < $resetPassword->getCreatedAt()->modify('+ 3 hour')) {
            if ($body['newPassword'] === $body['confirmationPassword']) {
               
    
                $password = $encoder->hashPassword($resetPassword->getUser(), $body['newPassword']);
                $resetPassword->getUser()->setPassword($password);
                $this->entityManager->flush();

                return new Response("password successfully updated");
            } else {
                return new Response("passwords didn't match");
            }
            
        } else {
            return new Response("token expired");
        }

    }
}
