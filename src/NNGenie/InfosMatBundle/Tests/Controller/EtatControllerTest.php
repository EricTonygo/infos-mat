<?php

namespace NNGenie\InfosMatBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EtatControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/etat/index');
    }

    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/etat/view');
    }

    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/etat/new');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/etat/edit');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/etat/delete');
    }

}
