<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Seller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsController]
class SellerRequestAnswerController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry        
    ) {}

  
    public function __invoke(int $id)
    {
        $body = json_decode($this->requestStack->getCurrentRequest()->getContent(),true);
        
        switch ($body['answer']){
            case 'accepted_request':
                $em = $this->managerRegistry->getManager();
                $getSeller = $em->getRepository(Seller::class)->findOneById($id);
                $getSeller->setIsActif(true);
                $user = new User();

                $user->setEmail($getSeller->getShopEmailContact());
                $user->setPassword($getSeller->getPassword());
                $user->setRoles(["ROLE_SELLER"]);
                
                
                $em->persist($user);
                $getSeller->setUserId($user->getId());
                $em->persist($getSeller);

                $em->flush();
                
                return new JsonResponse(['message' => 'sellerAdded', 'status' => 'success'], 201);
                
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