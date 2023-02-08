<?php
namespace App\Controller;

use App\Entity\Order;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\OrderDetails;
use App\Service\StripeService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class ManageProfileClientController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private ValidatorInterface $validator,
        private Security $security,
        private StripeService $stripeService
    ) {}

    public function __invoke()
    {
        

        $request = $this->requestStack->getCurrentRequest();
        $em = $this->managerRegistry->getManager();
        $body = json_decode($request->getContent(),true);
        $em->flush();

        $response = new Response();
        $response->setContent(json_encode(array("stripeSessionId"=>$order->getStripeSessionId())));
        return $response;
    }
}