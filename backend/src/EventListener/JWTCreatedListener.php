<?php

namespace App\EventListener;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Validator\Constraints\Length;

class JWTCreatedListener implements EventSubscriberInterface
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }
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
    # retreive the request object
    $request = $this->requestStack->getCurrentRequest();
    $content = $request->getContent();
    # format the result to have the email of the current user
    $tmp = explode("\n",$content)[1];
    $emailCurrentUser = substr($tmp,14,12);
    # get the current user by email
    $currentUser = $this->userRepository->findByEmail($emailCurrentUser)[0];
    # set the token payload
    $payload       = $event->getData();
    $payload['ip'] = $request->getClientIp();
    // add id of the current user on the payload
    $payload['id'] = $currentUser->getId();

    $event->setData($payload);

    $header        = $event->getHeader();
    $header['cty'] = 'JWT';

    $event->setHeader($header);
}
}


