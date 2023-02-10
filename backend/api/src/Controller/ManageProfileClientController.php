<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsController]
class ManageProfileClientController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private UserPasswordHasherInterface $passwordHasher,
        private ValidatorInterface $validator,
        private Security $security,
    ) {
    }

    public function __invoke()
    {
        $contract = [
            "password", "firstname", "lastname"
        ];

        $request = $this->requestStack->getCurrentRequest();
        $body = json_decode($request->getContent(), true);
        $currentUser = $this->security->getUser();
        $em = $this->managerRegistry->getManager();
        $newPassword = $body['password'];
        $newLastsname = $body['lastname'];
        $newFirstname = $body['firstname'];

        if (!empty($newPassword)) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $currentUser,
                $newPassword
            );
            $currentUser->setPassword($hashedPassword);
        }
        if (!empty($newFirstname)) {
            $currentUser->setFirstname($newFirstname);
        }
        if (!empty($newLastsname)) {
            $currentUser->setLastname($newLastsname);
        }

        $em->getRepository(User::class)->save($currentUser, true);
        return new JsonResponse(['message' => "Vos informations ont été mises à jour", 'status' => 'success'], 200);
        return;
    }
}
