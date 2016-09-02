<?php

namespace NNGenie\InfosMatBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentaireControllerControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'nn_genie_infos_mat_commentaire_index');
    }

    public function testNew()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'nn_genie_infos_mat_commentaire_new');
    }

    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'nn_genie_infos_mat_commentaire_view');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'nn_genie_infos_mat_commentaire_delete');
    }

}
