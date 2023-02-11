<?php
// api/tests/BooksTest.php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Request;

class SellerTest extends ApiTestCase
{
    //use RefreshDatabaseTrait;

    public function testRequestSellerAccount(): void
    {
        dd("hello");
        $client = self::createClient();
        $response = $client->request(Request::METHOD_POST, '/sellers');
    }

}