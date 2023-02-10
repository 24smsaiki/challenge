<?php

namespace App\Controller;

use App\Entity\Order;
use App\Service\MailService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class OrderFailController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private MailService $mail
    ) {
    }


    public function __invoke($stripeSessionId)
    {
        $order = $this->managerRegistry->getManager()->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        $content = "<h3>Attention le paiement de votre commande a échoué</h3>";

        $this->mail->send($order->getCustomer()->getEmail(), 'commande echouée', $content);

        return new JsonResponse(['message' => 'order success mail sent', 'status' => 'success'], 201);
    }
}
