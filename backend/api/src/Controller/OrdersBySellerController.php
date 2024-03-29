<?php
namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Order;
use App\Entity\Seller;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\OrderReturn;
use App\Entity\OrderDetails;
use App\Service\UserService;
use Stripe\Checkout\Session;
use App\Entity\OrderDetailsReturn;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class OrdersBySellerController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private ValidatorInterface $validator,
        private Security $security
    ) {}

    #[IsGranted('ROLE_SELLER')]
    public function __invoke()
    {
        $seller = $this->managerRegistry->getManager()->getRepository(Seller::class)->findOneByUserId($this->security->getUser()->getId());
       
        $queryBuilder = $this->managerRegistry->getManager()->createQueryBuilder('o');
        $queryBuilder->select('o')
            ->from(OrderDetails::class, 'o')
            ->leftJoin('o.myOrder','m')
            ->leftJoin('o.item','i')
            ->leftJoin('i.seller','s')
            ->where('s.id = :seller')
            ->andWhere('m.isPaid = true')
            ->groupBy('m.reference')
            ->orderBy('m.createdAt',"DESC")
            ->setParameter('seller', $seller)  
        ;

        $query = $queryBuilder->getQuery();
        $orderDetails = $query->getResult();
        $orderArray = array();
        $total = 0;
        foreach($orderDetails as $detail) {
            // $total += $detail->getTotalPrice();
            if($detail->getId())
            $orderArray[] = array(
                'reference' => $detail->getMyOrder()->getReference(),
                'createdAt' => $detail->getMyOrder()->getCreatedAt(),
            );
        }
        $response = new Response();
        $response->setContent(json_encode(array("orders"=>$orderArray)));
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");

        return $response;

        
        
    }
}