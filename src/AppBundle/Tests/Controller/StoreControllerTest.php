<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StoreControllerTest extends WebTestCase
{
    public function testSamrtphone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/store/phone');
    }

    public function testAccessories()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/store/accessories');
    }

    public function testRepair()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/store/repair');
    }

}
