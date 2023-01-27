<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\MailService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class ResetPasswordController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private MailService $mail
    ) {}

    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();
        $email = json_decode($request->getContent())->email;

        $em = $this->managerRegistry->getManager();
        
        /** @var User $user */
        if (!$user = $em->getRepository(User::class)->findOneBy(['email' => $email])) {
            return $this->createNotFoundException();
        }

        $user->setToken(bin2hex(random_bytes(32)));
        $em->flush();
        $content = "<h3>Vous avez demandé un nouveau mot de passe voici le lien"." https://localhost/update/password/".$user->getToken()."</h3>";
        $this->mail->send($email,'Reset password',$content);

        return new JsonResponse(['message' => 'reset password mail sent.', 'status' => 'success'], 201);
    }
}
