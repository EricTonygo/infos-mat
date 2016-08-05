<?php

namespace NNGenie\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NNGenieUserBundle:Default:index.html.twig');
    }
}
