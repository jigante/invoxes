<?php

namespace Agile\InvoiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Agile\InvoiceBundle\Entity\Client;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Agile\InvoiceBundle\Form\Type\ClientType;

class ClientsController extends Controller
{
    public function newAction(Request $request)
    {
        // create a $client object
        $client = new Client();
        $client->setCurrency('EUR');

        $form = $this->createForm(new ClientType(), $client);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($client);
                $em->flush();

                return $this->redirect($this->generateUrl('clients'));
            }
        }

        return $this->render('AgileInvoiceBundle:Clients:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function indexAction()
    {
        $clients = $this->getDoctrine()
            ->getRepository('AgileInvoiceBundle:Client')
            ->findAll()
        ;

        return $this->render('AgileInvoiceBundle:Clients:index.html.twig', array('clients' => $clients));
    }

}