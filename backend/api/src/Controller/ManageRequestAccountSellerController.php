<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Seller;

use App\Service\MailService;
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
        private ManagerRegistry $managerRegistry,
        private MailService $mailService        
    ) {}

  
    public function __invoke(int $id)
    {
        $body = json_decode($this->requestStack->getCurrentRequest()->getContent(),true);
        $getSeller = $this->managerRegistry->getRepository(Seller::class)->findOneById($id);
        $email = $getSeller->getShopEmailContact();
        $emailContent = "";
        $emailSubject = "";
        switch ($body['answer'])
        {
            case 'accepted_request':
                $em = $this->managerRegistry->getManager();
                if ($getSeller->getIsRequested() === true && $getSeller->getIsActif() === false) {

                    $getSeller->setIsActif(true);
                    $user = new User();

                    $user->setEmail($email);
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
                    $emailContent = "<h3>Votre compte vendeur a été validé vous pouvez désormais vous connecté avec l'adresse suivante : ".$email."<h3>";
                    $emailSubject = "Votre compte est pret"; 

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

                $emailContent = "<h3>Votre compte vendeur a été refusé vous pouvez contacter nos services pour plus d'inforamtions<h3>";
                $emailSubject = "Compte refusé"; 

                return new JsonResponse(['message' => 'seller request not Accepted', 'status' => 'success'], 201);


            $this->mailService->send($email,$emailSubject,$emailContent);    
        }
                
    }
}