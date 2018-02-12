<?php

/*
 * This file is part of the project package.
 *
 * (c) Oleg Timchenko <evo9.81@gmail.com>
 */

namespace Rest\ApiBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Cache\Adapter\TraceableAdapter;

/**
 * Class TokenListener
 */
class TokenListener
{
    /**
     * @var TraceableAdapter
     */
    private $cacheAdapter;

    /**
     * TokenListener constructor.
     *
     * @param TraceableAdapter $adapter
     */
    public function __construct(TraceableAdapter $adapter)
    {
        $this->cacheAdapter = $adapter;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onTokenEvent(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ('rest_api_users_post_users_register' !== $request->attributes->get('_route')) {
            $token = $request->headers->get('X-AUTH-TOKEN');

            $response = new Response();
            $response->setStatusCode(400);

            if (!$token || empty($token)) {
                return $event->setResponse($response);
            }

            $cachedUsers = $this->cacheAdapter->getItem('users');
            if (!$cachedUsers->isHit()) {
                return $event->setResponse($response);
            }

            $tokenList = $cachedUsers->get();

            if (!isset($tokenList[$token])) {
                return $event->setResponse($response);
            }
        }
    }
}