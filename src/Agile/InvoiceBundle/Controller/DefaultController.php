<?php

namespace Agile\InvoiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        // If is not disabled welcome in DB for user, show thw welcome page
        if (!$user->isDisabledWelcome()) {
            return $this->redirect($this->generateUrl('welcome'));
        } else {
            // Else show the overview page
            return $this->redirect($this->generateUrl('overview'));
        }
    }

    public function welcomeAction()
    {
        // render the welcome page
        return $this->render('AgileInvoiceBundle:Default:welcome.html.twig');
    }

    public function overviewAction()
    {
        // render the dashboard page
        return $this->render('AgileInvoiceBundle:Default:overview.html.twig');
    }
}
