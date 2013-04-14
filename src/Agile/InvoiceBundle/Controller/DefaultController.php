<?php

namespace Agile\InvoiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        //TODO: get the name of the user from db for the currently logged in user
        $name = 'Cristiano';

        // render the dashboard page
        return $this->render('AgileInvoiceBundle:Default:index.html.twig', array('name' => $name));
    }
}
