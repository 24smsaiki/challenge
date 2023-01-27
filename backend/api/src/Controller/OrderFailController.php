<?php
namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Order;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\OrderReturn;
use App\Entity\OrderDetails;
use App\Service\MailService;
use App\Service\UserService;
use Stripe\Checkout\Session;
use App\Entity\OrderDetailsReturn;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class OrderFailController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private MailService $mail

    ) {}

  
    public function __invoke($stripeSessionId)
    {
        $order = $this->managerRegistry->getManager()->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        
        $content = "<h3>Attention le paiement de votre commande a échoué</h3>";
        
        $this->mail->send($order->getCustomer()->getEmail(),'commande echouée',$content);

        return new JsonResponse(['message' => 'order success mail sent', 'status' => 'success'], 201);

        
    }
}