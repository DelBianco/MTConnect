<?php

namespace MTConnectBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LabControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/index');
    }

    public function testRecord()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/record');
    }

}
