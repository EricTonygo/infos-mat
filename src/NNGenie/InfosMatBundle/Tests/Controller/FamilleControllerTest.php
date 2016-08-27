<?php

namespace NNGenie\InfosMatBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FamilleControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/famille/index');
    }

    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/famille/view');
    }

    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/famille/new');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/famille/edit');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/famille/delete');
    }

}
