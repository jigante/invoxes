<?php

namespace Agile\InvoiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Agile\InvoiceBundle\Entity\Contact;
use Agile\InvoiceBundle\Form\Type\ContactFormType;

/**
 * Contact controller.
 *
 * @Route("/contacts")
 */
class ContactController extends Controller
{

    /**
     * Creates a new Contact entity.
     *
     * @Route("", name="contact_create")
     * @Method("POST")
     * @Template("AgileInvoiceBundle:Contact:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Contact();
        $company = $this->get('context.company');
        $form = $this->createForm(new ContactFormType(), $entity, array('company' => $company));
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('client'));
        }

        return array(
            'contact' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Contact entity.
     *
     * @Route("/new/{client_id}", name="contact_new", defaults={"client_id" = null})
     * @Method("GET")
     * @Template()
     */
    public function newAction($client_id)
    {
        $entity = new Contact();

        if ($client_id) {
            $client = $this->getDoctrine()->getRepository('AgileInvoiceBundle:Client')->find($client_id);
            
            if (!$this->get('security.context')->isGranted(array('CONTEXT'), $client)) {
                throw $this->createNotFoundException('Unable to find client');
            }
            
            $entity->setClient($client);
        }

        // If the company has no clients, return to clients page
        $company = $this->get('context.company');
        $clients = $this->getDoctrine()->getRepository('AgileInvoiceBundle:Client')->findActive($company);
        if (count($clients) == 0) {
            return $this->redirect($this->generateUrl('client'));
        }

        $form = $this->createForm(new ContactFormType, $entity, array('company' => $company));

        return array(
            'contact' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Contact entity.
     *
     * @Route("/{id}/edit", name="contact_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {   
        // Contact has to belong to logged in user company
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AgileInvoiceBundle:Contact')->find($id);

        if (!$this->get('security.context')->isGranted(array('CONTEXT'), $entity)) {
            throw $this->createNotFoundException('Unable to find Contact');
        }

        $company = $this->get('context.company');
        $editForm = $this->createForm(new ContactFormType(), $entity, array('company' => $company));

        return array(
            'contact'      => $entity,
            'form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Contact entity.
     *
     * @Route("/{id}", name="contact_update")
     * @Method("PUT")
     * @Template("AgileInvoiceBundle:Contact:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        // Contact has to belong to logged in user company
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AgileInvoiceBundle:Contact')->find($id);

        if (!$this->get('security.context')->isGranted(array('CONTEXT'), $entity)) {
            throw $this->createNotFoundException('Unable to find Contact');
        }

        $company = $this->get('context.company');
        $editForm = $this->createForm(new ContactFormType(), $entity, array('company' => $company));
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('client'));
        }

        return array(
            'contact'      => $entity,
            'form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Contact entity.
     *
     * @Route("/{id}", name="contact_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {   
        // Contact has to belong to logged in user company
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AgileInvoiceBundle:Contact')->find($id);

        if (!$this->get('security.context')->isGranted(array('CONTEXT'), $entity)) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('client'));
    }

    /**
     * Creates a form to delete a Contact entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
