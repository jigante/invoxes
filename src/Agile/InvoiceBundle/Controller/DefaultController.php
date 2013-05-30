<?php

namespace Agile\InvoiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // If is not disabled welcome in DB for user, show the welcome page
        if (!$this->isDisabledWelcome()) {
            return $this->redirect($this->generateUrl('welcome'));
        } else {
            // Else show the overview page
            return $this->redirect($this->generateUrl('overview'));
        }
    }

    public function welcomeAction()
    {        
        // If is disabled welcome in DB for user, show the overview page
        if ($this->isDisabledWelcome()) {
            return $this->redirect($this->generateUrl('overview'));
        }

        // render the welcome page
        return $this->render('AgileInvoiceBundle:Default:welcome.html.twig');
    }

    public function overviewAction()
    {
        // If is not disabled welcome in DB for user, show the welcome page
        if (!$this->isDisabledWelcome()) {
            return $this->redirect($this->generateUrl('welcome'));
        }

        // render the dashboard page
        return $this->render('AgileInvoiceBundle:Default:overview.html.twig');
    }

    private function isDisabledWelcome()
    {
        $user = $this->getUser();
        return $this->getDoctrine()->getRepository('AgileInvoiceBundle:User')->isDisabledWelcome($user);
    }
}
