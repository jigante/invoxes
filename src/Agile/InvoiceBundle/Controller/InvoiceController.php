<?php

namespace Agile\InvoiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
// use Agile\InvoiceBundle\Entity\Invoice;
use Agile\InvoiceBundle\Form\InvoiceType;
use Agile\InvoiceBundle\Entity\UserSetting;

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
        $settingName = UserSetting::DISABLE_INVOICE_PAGE_TIPS;
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $isActiveSetting = $em->getRepository('AgileInvoiceBundle:UserSetting')->isActive(
            $user,
            $settingName
        );

        $tips = array('show' => $isActiveSetting);

        return array(
            'tips' => $tips,
            'settingName' => $settingName,
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
