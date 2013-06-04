<?php

namespace Agile\InvoiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {        
        // If is not disabled welcome in DB for user, show the welcome page
        if (!$this->getUser()->isDisabledWelcome()) {
            return $this->redirect($this->generateUrl('welcome'));
        } else {
            // Else show the overview page
            return $this->redirect($this->generateUrl('overview'));
        }
    }

    /**
     * @Route("/welcome", name="welcome")
     */
    public function welcomeAction()
    {        
        // If is disabled welcome in DB for user, show the overview page
        if ($this->getUser()->isDisabledWelcome()) {
            return $this->redirect($this->generateUrl('overview'));
        }

        // render the welcome page
        return $this->render('AgileInvoiceBundle:Default:welcome.html.twig');
    }

    /**
     * @Route("/overview", name="overview")
     */
    public function overviewAction()
    {
        // If is not disabled welcome in DB for user, show the welcome page
        if (!$this->getUser()->isDisabledWelcome()) {
            return $this->redirect($this->generateUrl('welcome'));
        }

        // render the dashboard page
        return $this->render('AgileInvoiceBundle:Default:overview.html.twig');
    }
    
}
