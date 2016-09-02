<?php

namespace NNGenie\InfosMatBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DisponibilitematerielControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/disponibilitemateriel/index');
    }

    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/disponibilitemateriel/view');
    }

    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/disponibilitemateriel/new');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/disponibilitemateriel/edit');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/disponibilitemateriel/delete');
    }

}
