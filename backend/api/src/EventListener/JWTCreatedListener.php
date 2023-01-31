<?php

namespace App\EventListener;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    
/**
 * @var RequestStack
 */
private $requestStack;
/**
 * @var UserRepository
 */
private $userRepository;
/**
 * @param RequestStack $requestStack
 */
public function __construct(RequestStack $requestStack, UserRepository $userRepository)
{
    $this->requestStack = $requestStack;
    $this->userRepository = $userRepository;
}

/**
 * @param JWTCreatedEvent $event
 *
 * @return void
 */
public function onJWTCreated(JWTCreatedEvent $event)
{
    $request = $this->requestStack->getCurrentRequest();
    $content = json_decode($request->getContent(), true);

    $currentUser = $this->userRepository->findOneBy(['email'=>$content["email"]]);
    $payload = $event->getData();
    $payload['id'] = $currentUser->getId();
    
    $event->setData($payload);

    $header = $event->getHeader();
    $header['cty'] = 'JWT';

    $event->setHeader($header);
}
}

