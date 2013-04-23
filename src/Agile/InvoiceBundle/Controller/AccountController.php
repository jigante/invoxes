<?php

namespace Agile\InvoiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Agile\InvoiceBundle\Entity\Account;
use Agile\InvoiceBundle\Form\AccountType;

class AccountController extends Controller
{
    /**
     * @Route("/signup", name="account_signup")
     * @Method("GET")
     * @Template()
     */
    public function signupAction()
    {
        $entity = new Account();

        $form = $this->createForm(new AccountType(), $entity);

        return array(
            'account' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new Account entity.
     *
     * @Route("/signup", name="account_create")
     * @Method("POST")
     * @Template("AgileInvoiceBundle:Account:signup.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Account();
        $form = $this->createForm(new AccountType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('account_create_success'));
        }

        return array(
            'client' => $entity,
            'form'   => $form->createView(),
        );
    }

}
