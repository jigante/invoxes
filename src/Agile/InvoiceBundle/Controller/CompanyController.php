<?php 

namespace Agile\InvoiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Agile\InvoiceBundle\Form\Type\CompanyPreferencesFormType;

/**
 * Company Controller.
 * 
 * @Route("/company")
 */
class CompanyController extends Controller
{

    /**
     * @Route("/account", name="company_account")
     * @Template()
     */
    public function accountAction()
    {
        $company = $this->get('context.company');

        return array(
            'company' => $company,
        );
    }

    /**
     * @Route("/preferences", name="company_preferences")
     * @Template()
     */
    public function preferencesAction()
    {
        $company = $this->get('context.company');

        $form = $this->createForm(new CompanyPreferencesFormType(), $company);

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/preferences", name="company_preferences_update")
     * @Method("PUT")
     * @Template("AgileInvoiceBundle:Company:preferences.html.twig")
     */
    public function preferencesUpdateAction(Request $request)
    {
        # code...
    }
}