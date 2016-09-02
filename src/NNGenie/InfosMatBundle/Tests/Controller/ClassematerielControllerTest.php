<?php

namespace NNGenie\InfosMatBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClassematerielControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Classemateriel/index');
    }

    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Classemateriel/new');
    }

    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Classemateriel/view/{id}');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'Classemateriel/edit/{id}');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'Classemateriel/delete/{id}');
    }

}
