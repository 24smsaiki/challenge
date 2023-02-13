<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
class CreateProductController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
    ) {}

    public function __invoke(Request $request)
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $product = new Product();
        $product->image = $uploadedFile;

        return $product;
        
    }
}
