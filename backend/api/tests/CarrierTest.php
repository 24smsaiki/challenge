<?php

namespace App\Tests\Entity;

use App\Entity\Carrier;
use PHPUnit\Framework\TestCase;

class CarrierTest extends TestCase
{
    public function testUserEntity()
    {
        $addres = new Carrier();
        $addres->setLabel("dhl");
        $addres->setFees(10);
        
       


        $this->assertEquals("dhl", $addres->getLabel());
        $this->assertEquals(10, $addres->getFees());
      
    }
}