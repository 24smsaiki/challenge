<?php
namespace App\Controller;

use App\Entity\OrderDetailsReturn;
use App\Entity\OrderReturn;
use App\Entity\User;
use App\Entity\Seller;

use App\Service\MailService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class ManageReturnByAdminController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private MailService $mailService        
    ) {}

  
    public function __invoke()
    {
        $body = json_decode($this->requestStack->getCurrentRequest()->getContent(),true);
        $idReturn = $body["idReturn"];
        $finalState = $body["state"];
        $customerEmail = $body["customerEmail"];
        $orderReturn = $this->managerRegistry->getRepository(OrderReturn::class)->findOneById($idReturn);
        $orderReference = "ref102301";
        // update orderReturn
        $em = $this->managerRegistry->getManager();
        $orderReturn->setState($finalState);
        $em->persist($orderReturn);
        $em->flush();



        $emailContent = "";
        $emailSubject = "";
        switch ($finalState)
        {
            case 2: // return was accepted
                // needs : the total price of the return  
                $queryBuilder = $em->createQueryBuilder('or');
                $queryBuilder->select('or')
                ->from(OrderReturn::class, 'or')
                ->innerJoin('', '');
                
                $totalReturn = strval(40); // to string before
                $emailContent = "<h3>Votre retour pour la commande numéro : ".$orderReference."  a été accepté vous allez recevoir un virement de : ".$totalReturn."$ prochainement sur votre compte !"."<h3>";
                $emailSubject = "Retour sur produit Accepté"; 

                return new JsonResponse(['message' => 'request return was accepted, email was sent to customer', 'status' => 'success'], 200);
                
            case 3: // reutrn declined
                
                $emailContent = "<h3>Votre retour pour la commande numéro : ".$orderReference." car le produit a été mal entretenue avant le retour, nous en somme navré mais nous ne pouvons pas procéder a un rembourssement"."<h3>";
                $emailSubject = "Retour sur produit Refusé"; 

                return new JsonResponse(['message' => 'request return was declined, email was sent to customer', 'status' => 'success'], 200);


            $this->mailService->send($customerEmail,$emailSubject,$emailContent);    
        }
                
    }
}