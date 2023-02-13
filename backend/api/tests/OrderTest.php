<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\OrderDetails;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testUserEntity()
    {
        $order = new Order();
        $orderDetail = new OrderDetails(1);
        $user = new User(1);
        $carrier = new Carrier(1);
        $address = new Address(1);

        $order->setReference('ref1');
        $order->setIsPaid(true);
        $order->setState(1);
        $order->setTotal(100);
        $order->setCustomer($user);
        $order->setDelivery($address);
        $order->addOrderDetail($orderDetail);
        $order->setCarrier($carrier);
        $order->setStripeSessionId('cs_test_123');

        
       


        $this->assertEquals("ref1", $order->getReference());
        $this->assertEquals(true, $order->getIsPaid());
        $this->assertEquals(1, $order->getState());
        $this->assertEquals(100, $order->getTotal());
        $this->assertEquals($user, $order->getCustomer());
        $this->assertEquals($address, $order->getDelivery());
        $this->assertEquals($carrier, $order->getCarrier());
        $this->assertEquals('cs_test_123', $order->getStripeSessionId());
      
    }
}