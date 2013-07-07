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
            'reference_date' => mktime(0, 0, 0, 4, 23, date('Y')),
        );
    }

    /**
     * @Route("/preferences", name="company_preferences")
     * @Method("GET")
     * @Template()
     */
    public function preferencesAction()
    {
        $company = $this->get('context.company');
        $translator = $this->get('translator');
        $form = $this->createForm(new CompanyPreferencesFormType(), $company, array('translator' => $translator));

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
        $company = $this->get('context.company');
        $translator = $this->get('translator');
        $form = $this->createForm(new CompanyPreferencesFormType(), $company, array('translator' => $translator));
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            return $this->redirect($this->generateUrl('company_account'));
        }

        return array(
            'form' => $form->createView(),
        );
    }
}