<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        $listProducts = array();

        foreach ($products as $product) {
            $listProducts[] = array(
                'id'     => $product->getId(),
                'title'    => $product->getTitle(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
            );
        }
        $reponse = new Response();
        $reponse->setContent(json_encode($listProducts));
        $reponse->headers->set("Content-Type", "application/json");
        $reponse->headers->set("Access-Control-Allow-Origin", "*");
        return $reponse;
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        
        $body   = json_decode($request->getContent(), true);
        $title    = $body['title'];
        $description = $body['description'];
        $price = $body['price'];
        $quantity = $body['quantity'];
        
        $product->setTitle($title);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setQuantity($quantity);
        
        $productRepository->save($product, true);
        $reponse = new Response('added successfully');
        $reponse->headers->set("Content-Type", "application/json");
        $reponse->headers->set("Access-Control-Allow-Origin", "*");
     
        return $reponse;
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        $productArray[] = array(
            'id'     => $product->getId(),
            'title'    => $product->getTitle(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'quantity' => $product->getQuantity()
        );
        
        $reponse = new Response();
        $reponse->setContent(json_encode($productArray));
        $reponse->headers->set("Content-Type", "application/json");
        $reponse->headers->set("Access-Control-Allow-Origin", "*");
        
        return $reponse;
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        //TODO
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $productRepository->remove($product,true);
        $reponse = new Response('removed successfully');
        $reponse->headers->set("Access-Control-Allow-Origin", "*");

        return $reponse;
    }
}
