<?php

namespace App\Controller;

use App\Entity\Seller;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsController]
class ManageShopInfoController extends AbstractController
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
            "shopLabel", "shopDescription", "shopPhoneContact"
        ];

        $request = $this->requestStack->getCurrentRequest();
        $body = json_decode($request->getContent(), true);
        $currentUserId = $this->security->getUser()->getId();
        $current_seller = $this->managerRegistry->getRepository(Seller::class)->findOneBy(['userId' => $currentUserId]);
        $em = $this->managerRegistry->getManager();
        $newShopLabel = $body['shopLabel'];
        $newShopDescription = $body['shopDescription'];
        $newShopPhoneContact = $body['shopPhoneContact'];

        if (!empty($newShopLabel)) {
            $current_seller->setShopLabel($newShopLabel);
        }
        if (!empty($newShopDescription)) {
            $current_seller->setShopDescription($newShopDescription);
        }
        if (!empty($newShopPhoneContact)) {
            $current_seller->getShopPhoneContact($newShopPhoneContact);
        }

        $em->getRepository(Seller::class)->save($current_seller, true);
        return new JsonResponse(['message' => "les informations du shop ont été mises à jour", 'status' => 'success'], 200);
        return;
    }
}
