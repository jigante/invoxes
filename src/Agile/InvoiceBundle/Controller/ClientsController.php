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
        // $client->setName('ISMatera 24 S.r.l.');
        // $client->setAddress(
        //     "Via Bari 2-4-6\n 75100 Matera\n P.IVA 01137970776"
        // );
        $client->setCurrency('EUR');

        // $form = $this->createFormBuilder($client)
        //     ->add('name', 'text')
        //     ->add('address', 'textarea')
        //     ->add('currency', 'hidden')
        //     ->getForm()
        // ;

        $form = $this->createForm(new ClientType(), $client);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database

                return $this->redirect($this->generateUrl('task_success'));
            }
        }

        return $this->render('AgileInvoiceBundle:Clients:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Template("AgileInvoiceBundle:Clients:index.html.twig")
     */
    public function indexAction()
    {
        // $this->render('AgileInvoiceBundle')
        return array();
    }

}