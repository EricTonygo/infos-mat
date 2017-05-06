<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/accueil")
     * @Template()
     */
    public function indexGesmattAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index_gesmatt.html.twig');
    }
    
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }
}
