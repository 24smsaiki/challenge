<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Seller;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class ManageRequestAccountSellerController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry
    ) {
    }


    public function __invoke(int $id)
    {
        $body = json_decode($this->requestStack->getCurrentRequest()->getContent(), true);

        switch ($body['answer']) {
            // TODO : communiquer plus tard avec le front le 'accepted_request' et 'declined_request'
            case 'accepted_request':
                $em = $this->managerRegistry->getManager();
                $getSeller = $em->getRepository(Seller::class)->findOneById($id);
                if ($getSeller->getIsRequested() === true && $getSeller->getIsActif() === false) {
                    $getSeller->setIsActif(true);
                    $user = new User();

                    $user->setEmail($getSeller->getShopEmailContact());
                    $user->setPassword($getSeller->getPassword());
                    $user->setRoles(["ROLE_SELLER"]);
                    $user->setIsActif(true);
                    $user->setFirstname($getSeller->getFirstname());
                    $user->setLastname($getSeller->getLastname());


                    $em->persist($user);
                    $em->flush();
                    $getSeller->setUserId($user->getId());

                    $em->persist($getSeller);
                    $em->flush();

                    return new JsonResponse(['message' => 'seller request accepted', 'status' => 'success'], 201);
                } else {
                    return new JsonResponse(['message' => 'something went wrong retry', 'status' => 'success'], 201);
                }


            case 'declined_request':
                $em = $this->managerRegistry->getManager();
                $getSeller = $em->getRepository(Seller::class)->findOneById($id);
                $getSeller->setIsDeclined(true);
                $em->persist($getSeller);
                $em->flush();
                return new JsonResponse(['message' => 'seller request not Accepted', 'status' => 'success'], 201);
        }
    }
}
