<?php

namespace Acme\HelloBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HelloController extends Controller
{
    public function indexAction($name)
    {
        // return new Response('<html><body>Hello '.$name.'!</body></html>');
        return $this->render(
            'AcmeHelloBundle:Hello:index.html.twig',
            array('name' => $name)
        );
    }
}