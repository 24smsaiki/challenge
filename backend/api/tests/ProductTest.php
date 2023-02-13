<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Seller;
use App\Entity\Product;
use App\Entity\products;
use PHPUnit\Framework\TestCase;

class productsTest extends TestCase
{
    public function testUserEntity()
    {
        $publisher = new Seller(1);
        $product = new Product();
        $product->setlabel("product title");
        $product->setdescription("product description");
        $product->setprice(10);
        $product->setstockQuantity(200);
        $product->setPublisher($publisher);

       


        $this->assertEquals("product title", $product->getlabel());
        $this->assertEquals("product description", $product->getdescription());
        $this->assertEquals(10, $product->getprice());
        $this->assertEquals(200, $product->getstockQuantity());
        $this->assertEquals($publisher, $product->getPublisher());

    }
}