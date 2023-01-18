<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/address')]
class AddressController extends AbstractController
{
    #[Route('/', name: 'app_address_index', methods: ['GET'])]
    public function index(AddressRepository $addressRepository): Response
    {
        
        $addresses = $addressRepository->findAll();
        $listAddresses = array();
        foreach ($addresses as $address) {
            $listAddresses[] = array(
                'id'     => $address->getId(),
                'firstname'    => $address->getFirstname(),
                'lastname' => $address->getLastname(),
                'phone' => $address->getPhone(),
                'addressField' => $address->getAddressField(),
                'addressInformation' => $address->getAddressInformation(),
                'user' => $address->getUser()->getId()
            );
        }
        $reponse = new Response();
        $reponse->setContent(json_encode($listAddresses));
        $reponse->headers->set("Content-Type", "application/json");
        $reponse->headers->set("Access-Control-Allow-Origin", "*");
        return $reponse;
    }

    #[Route('/new', name: 'app_address_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AddressRepository $addressRepository, UserRepository $userRepository): Response
    {
        $address = new Address();
        $body   = json_decode($request->getContent(), true);
        $user = $userRepository->findOneById($body['user']);
        $address->setFirstname($body['firstname']);
        $address->setLastname($body['lastname']);
        $address->setPhone($body['phone']);
        $address->setAddressField($body['addressField']);
        $address->setAddressInformation($body['addressInformation']);
        $address->setUser($user);
        
        $addressRepository->save($address, true);
        $reponse = new Response('added successfully');
        $reponse->headers->set("Content-Type", "application/json");
        $reponse->headers->set("Access-Control-Allow-Origin", "*");
     
        return $reponse;
        
    }

    #[Route('/{id}', name: 'app_address_show', methods: ['GET'])]
    public function show(Address $address): Response
    {
        
        $arrayAddress[] = array(
            'id'     => $address->getId(),
            'firstname'    => $address->getFirstname(),
            'lastname' => $address->getLastname(),
            'phone' => $address->getPhone(),
            'addressField' => $address->getAddressField(),
            'addressInformation' => $address->getAddressInformation(),
            'user' => $address->getUser()->getId()
        );
        $reponse = new Response();
        $reponse->setContent(json_encode($arrayAddress));
        $reponse->headers->set("Content-Type", "application/json");
        $reponse->headers->set("Access-Control-Allow-Origin", "*");
        return $reponse;
    }

    #[Route('/{id}/edit', name: 'app_address_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Address $address, AddressRepository $addressRepository): Response
    {
        //TODO
    }

    #[Route('/{id}', name: 'app_address_delete', methods: ['POST'])]
    public function delete(Request $request, Address $address, AddressRepository $addressRepository): Response
    {
        
        $addressRepository->remove($address,true);
        $reponse = new Response('removed successfully');
        $reponse->headers->set("Access-Control-Allow-Origin", "*");

        return $reponse;
    }
}
