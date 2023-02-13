<?php

namespace App\Tests\Entity;

use App\Entity\Seller;
use PHPUnit\Framework\TestCase;

class SellerTest extends TestCase
{
    public function testsellerEntity()
    {
        $seller = new Seller();
        $seller->setShopEmailContact("john.doe@example.com");
        $seller->setFirstname("john");
        $seller->setLastname("doe");
        $seller->setPassword("password");
        $seller->setIsActif(true);
        $seller->setShopLabel("test shop");
        $seller->setShopDescription("description");
        $seller->setIsRequested(true);
        $seller->setUserId(1);
       


        $this->assertEquals("john.doe@example.com", $seller->getShopEmailContact());
        $this->assertEquals("description", $seller->getShopDescription());
        $this->assertEquals("test shop", $seller->getShopLabel());
        $this->assertEquals(1, $seller->getUserId());
        $this->assertEquals("john", $seller->getFirstname());
        $this->assertEquals("doe", $seller->getLastname());
        $this->assertEquals("password", $seller->getPassword());
        $this->assertEquals(true, $seller->getIsActif());
        $this->assertEquals(true, $seller->getIsRequested());


    }
}