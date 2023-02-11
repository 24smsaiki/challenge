<?php
// api/tests/BooksTest.php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class SellerTest extends WebTestCase
{
    //use RefreshDatabaseTrait;

    public function testRequestSellerAccount(): void
    {
        $client = self::createClient();
        $response = $client->request(Request::METHOD_POST, '/sellers');
        dd($response);
    }

}