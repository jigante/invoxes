<?php

namespace Agile\InvoiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Agile\InvoiceBundle\Entity\Client;
use Agile\InvoiceBundle\Form\ClientType;

/**
 * Client controller.
 *
 * @Route("/clients")
 */
class ClientController extends Controller
{

    /**
     * Lists all Client entities.
     *
     * @Route("", name="client")
     * @Route("/", name="client_slash")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $company = $this->get('context.company');
        $clients = $this->getDoctrine()->getRepository('AgileInvoiceBundle:Client')->findAllOrderedByName($company);

        $numInactiveClients = $this->getDoctrine()->getRepository('AgileInvoiceBundle:Client')->countInactiveClients($company);


        return array(
            'clients' => $clients,
            'numInactiveClients' => $numInactiveClients,
        );
    }

    /**
     * @Template()
     */
    public function contactListAction($client_id)
    {
        $contacts = $this->getDoctrine()->getRepository('AgileInvoiceBundle:Client')->findContacts($client_id);

        return array(
            'contacts' => $contacts
        );
    }

    /**
     * @Route("/{id}/contacts/new", name="client_contact_new")
     */
    public function clientContactNewAction($id)
    {
        $response = $this->forward('AgileInvoiceBundle:Contact:new', array(
            'client_id' => $id
        ));

        return $response;
    }

    /**
     * @Route("/{client_id}/contacts/{contact_id}/edit", name="client_contact_edit")
     */
    public function clientContactEditAction($client_id, $contact_id)
    {
        $response = $this->forward('AgileInvoiceBundle:Contact:edit', array(
            'id' => $contact_id
        ));

        return $response;
    }

    /** Show inactive clients
     *
     * @Route("/inactive", name="client_inactive") 
     * @Template()
     */
    public function inactiveAction()
    {
        $company = $this->get('context.company');
        $clients = $this->getDoctrine()->getRepository('AgileInvoiceBundle:Client')->findInactive($company);

        return array(
            'clients' => $clients,
        );
    }

    /**
     * Toggles the client as archived or not archived
     *
     * @Route("/{id}/toggle", name="client_toggle")
     */
    public function toggleAction($id)
    {
        $company = $this->get('context.company');
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('AgileInvoiceBundle:Client')->findOneBy(array(
            'id' => $id,
            'company' => $company
        ));

        if (!$client) {
            throw $this->createNotFoundException('Unable to find client ' . $id);
        }

        // Toggle the $archivedProperty
        $client->setArchived(!$client->isArchived());
        $em->flush();

        return $this->redirect($this->generateUrl('client'));

    }

    /**
     * Creates a new Client entity.
     *
     * @Route("", name="client_create")
     * @Method("POST")
     * @Template("AgileInvoiceBundle:Client:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Client();

        // Always assign actual company to Client
        $entity->setCompany($this->get('context.company'));

        $form = $this->createForm(new ClientType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('client'));
        }

        return array(
            'client' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Client entity.
     *
     * @Route("/new", name="client_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Client();
        $entity->setCurrency('EUR');

        $form   = $this->createForm(new ClientType(), $entity);

        return array(
            'client' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Client entity.
     *
     * @Route("/{id}/edit", name="client_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $company = $this->get('context.company');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AgileInvoiceBundle:Client')->findOneBy(array(
            'id' => $id,
            'company' => $company
        ));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Client');
        }

        $editForm = $this->createForm(new ClientType(), $entity);

        return array(
            'client'      => $entity,
            'form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Client entity.
     *
     * @Route("/{id}", name="client_update")
     * @Method("PUT")
     * @Template("AgileInvoiceBundle:Client:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $company = $this->get('context.company');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AgileInvoiceBundle:Client')->findOneBy(array(
            'id' => $id,
            'company' => $company
        ));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Client');
        }

        $editForm = $this->createForm(new ClientType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('client'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Client entity.
     *
     * @Route("/{id}", name="client_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $company = $this->get('context.company');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AgileInvoiceBundle:Client')->findOneBy(array(
            'id' => $id,
            'company' => $company
        ));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Client');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('client'));
    }

}
