<?php

namespace NNGenie\InfosMatBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdresseControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/adresse/adresse');
    }

    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/adresse/view');
    }

    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/adresse/new');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/adresse/edit');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/adresse/delete');
    }

}
