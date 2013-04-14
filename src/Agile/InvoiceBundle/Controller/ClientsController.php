<?php

namespace Agile\InvoiceBundle\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ClientsController 
/*extends Controller*/
{
    
    /**
     * @Template("AgileInvoiceBundle:Clients:index.html.twig")
     */
    public function indexAction()
    {
        // $this->render('AgileInvoiceBundle')
        return array();
    }

    /**
     * @Template
     */
    public function newAction()
    {
        return array();
    }
}