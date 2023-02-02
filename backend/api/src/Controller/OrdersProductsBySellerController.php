<?php

namespace App\Controller;

use App\Entity\Seller;
use App\Entity\OrderDetails;
use App\Service\UserService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class OrdersProductsBySellerController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private ValidatorInterface $validator,
        private Security $security
    ) {}

    #[IsGranted('ROLE_SELLER')]
    public function __invoke($reference)
    {
        $productsArray = array();
        $seller = $this->managerRegistry->getManager()->getRepository(Seller::class)->findOneByUserId($this->security->getUser()->getId());
        
       
        $queryBuilder = $this->managerRegistry->getManager()->createQueryBuilder('o');
        $queryBuilder->select('o')
            ->from(OrderDetails::class, 'o')
            ->leftJoin('o.myOrder','m')
            ->leftJoin('o.item','i')
            ->leftJoin('i.seller','s')
            ->where('s.id = :seller')
            ->andWhere('m.reference = :reference')
            ->orderBy('m.createdAt',"DESC")
            ->setParameter('seller', $seller)  
            ->setParameter('reference', $reference)
        ;

        $query = $queryBuilder->getQuery();
        $products = $query->getResult();
    
        
        foreach($products as $product) {
            $productsArray[] = array(
                'label' => $product->getItem()->getLabel(),
                'price' => $product->getItem()->getPrice(),
                'quantity' => $product->getQuantity()
            );
        }
        
        $response = new Response();
        $response->setContent(json_encode(array("items"=>$productsArray)));
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        return $response;
       
        
        
    }
}