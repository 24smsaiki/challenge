<?php

namespace App\Tests\Entity;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserEntity()
    {
        $user = new User();
        $user->setEmail("john.doe@example.com");
        $user->setFirstname("john");
        $user->setLastname("doe");
        $user->setPassword("password");
        $user->setRoles(["ROLE_USER"]);
        $user->setIsActif(true);


        $this->assertEquals("john.doe@example.com", $user->getEmail());
        $this->assertEquals("john", $user->getFirstname());
        $this->assertEquals("doe", $user->getLastname());
        $this->assertEquals("password", $user->getPassword());
        $this->assertEquals(true, $user->getIsActif());


    }
}