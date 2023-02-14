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
class OrderSuccessController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private MailService $mail

    ) {}

  
    public function __invoke($stripeSessionId)
    {
        $order = $this->managerRegistry->getManager()->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        foreach ($order->getOrderDetails() as $detail) {
           $product =  $this->managerRegistry->getManager()->getRepository(Product::class)->findOneById($detail->getItem()->getId());
           $newItemQuantity = ($product->getStockQuantity() - $detail->getQuantity());
           $product->setStockQuantity($newItemQuantity);
        }
        $order->setIsPaid(1);
        $em = $this->managerRegistry->getManager();
        $em->persist($order);
        $em->persist($product);
        $em->flush();
        
        $content = "<h3>Felicition votre commande a bien été confirmé</h3>";
        $this->mail->send($order->getCustomer()->getEmail(),'commande confirmée',$content);

        return new JsonResponse(['message' => 'Votre commande a bien été effectué !', 'status' => 'success'], 201);

        
    }
}