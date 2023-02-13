<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    public function testUserEntity()
    {
        $user = new User(1);
        $addres = new Address();
        $addres->setFirstname("john");
        $addres->setLastname("doe");
        $addres->setAddressField("10 rue de paris");
        $addres->setzipCode("75012");
        $addres->setcity("paris");
        $addres->setcountry("france");
        $addres->setcustomer($user);

       


        $this->assertEquals("john", $addres->getFirstname());
        $this->assertEquals("doe", $addres->getLastname());
        $this->assertEquals("10 rue de paris", $addres->getAddressField());
        $this->assertEquals("75012", $addres->getzipCode());
        $this->assertEquals("paris", $addres->getcity());
        $this->assertEquals("france", $addres->getCountry());
        $this->assertEquals($user, $addres->getcustomer());

    }
}