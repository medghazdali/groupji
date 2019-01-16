<?php

namespace GJI\GJIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GJIBundle:Default:index.html.twig');
    }
}
