<?php

/*
 * This file is part of the project package.
 *
 * (c) Oleg Timchenko <evo9.81@gmail.com>
 */

namespace Rest\ApiBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Rest\ApiBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Class AuthListener
 */
class AuthListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * AuthListener constructor.
     *
     * @param EntityManager $entityManager
     * @param TokenStorage  $tokenStorage
     */
    public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onAuthEvent(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ('rest_api_users_post_users_register' !== $request->attributes->get('_route')) {
            $token = $request->headers->get('X-AUTH-TOKEN');

            $user = $this->entityManager->getRepository(User::class)->findOneBy(
                [
                    'confirmationToken' => $token,
                ]
            );

            if (!$user) {
                $response = new Response();
                $response->setStatusCode(403);

                return $event->setResponse($response);
            }

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());

            return $this->tokenStorage->setToken($token);
        }
    }
}