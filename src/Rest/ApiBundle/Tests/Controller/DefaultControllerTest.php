<?php

namespace Rest\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/index.json');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}
