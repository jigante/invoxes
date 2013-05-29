<?php

namespace Agile\InvoiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Agile\InvoiceBundle\Entity\Invoice;
use Agile\InvoiceBundle\Form\InvoiceType;

/**
 * Client controller.
 *
 * @Route("/invoices")
 */
class InvoiceController extends Controller
{

    /**
     * Invoces overview page
     * 
     * @Route("", name="invoice")
     * @Route("/", name="invoice_slash")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        
        // Show tips on page?
        $invoiceTips = $em->getRepository('AgileInvoiceBundle:UserSetting')->findOneBy(array(
            'user' => $user,
            'name' => 'InvoicePageTips',
        ));

        $tips = array('show' => false);
        if ($invoiceTips AND $invoiceTips->getValue()) {
            $tips['show'] = true;
        }

        return array(
            'tips' => $tips,
        );
    }

    /**
     * Invoices configuration page
     *
     * @Route("/configure", name="invoice_configure")
     * @Method("GET")
     * @Template()
     */
    public function configureAction()
    {
        
    }

    /**
     * Invoices report page
     *
     * @Route("/archive", name="invoice_archive")
     * @Method("GET")
     * @Template()
     */
    public function archiveAction()
    {
        
    }

    /**
     * Invoices creation page
     *
     * @Route("/new", name="invoice_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        
    }

}
