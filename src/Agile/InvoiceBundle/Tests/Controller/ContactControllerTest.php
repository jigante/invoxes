<?php

namespace Agile\InvoiceBundle\Tests\Controller;

use Agile\InvoiceBundle\Tests\TestCase;

class ContactControllerTest extends TestCase
{

    public function testCompleteScenario()
    {
        // Get the client to browse the application
        $client = $this->client;

        // Login as "walter.zenga"
        $this->logIn();

        // Add a new contact
        $crawler = $client->request('GET', '/clients');

        // Before all, we need to create a new client
        // without testing Client creation because it is done in a different test
        $link = $crawler->selectLink('+ Create Client')->link();
        $crawler = $client->click($link);

        $form = $crawler->selectButton('Save')->form(array(
            'agile_invoice_client[name]' => 'Test Client for contact',
            'agile_invoice_client[address]' => 'Address of Test Client for contact'
        ));

        $crawler = $client->submit($form);

        $crawler = $client->followRedirect();

        // So now we again in "/clients" page and can start adding a Contact
        $link = $crawler->selectLink('+ Add Contact')->link();

        $this->assertRegExp('/\/contacts\/new/', $link->getUri());

        $crawler = $client->click($link);

        $this->assertRegExp('/Add Contact/', $client->getResponse()->getContent());

        // Select box contains two clients in the list
        $this->assertCount(2, $crawler->filter('select#agile_invoice_contact_client > option'), 'There have to be two Client options in the add contact form');

        $this->assertCount(1, $crawler->filter('select#agile_invoice_contact_client > option:contains("Inter FGCI")'));
        $this->assertCount(1, $crawler->filter('select#agile_invoice_contact_client > option:contains("Test Client for contact")'));
        

        // Testiamo l'invio del form vuoto
        $form = $crawler->selectButton('Save')->form();
        $crawler = $client->submit($form);

        // Dobbiamo avere due messaggi di errore "This value should not be blank."
        $formErrors = $crawler->filter('li.help-inline:contains("This value should not be blank.")');
        $this->assertEquals(2, $formErrors->count());

        // Send again the form only with First name and Last Name
        $form = $crawler->selectButton('Save')->form(array(
            'agile_invoice_contact[firstName]' => 'Test Contact First name',
            'agile_invoice_contact[lastName]' => 'Test Contact Last name'
        ));
        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/clients'));

        $crawler = $client->followRedirect();

        $contact = $crawler->filter('.contact-main-info:contains("Test Contact First name Test Contact Last name")');
        $this->assertGreaterThan(0, $contact->count(), 'Il contatto non è stato creato');
        
        // Modifichiamo il dato appena creato, inserendo gli altri valori
        $link = $contact->parents()->filter('a.edit-button')->eq(0)->link();
        // $link = $crawler->selectLink($contactEditButton)->link();
        $crawler = $client->click($link);

        // need to be sure the Client form field is not present
        $this->assertEquals(
            0,
            $crawler->filter('select#contact_client')->count(),
            'Il campo "Cliente" non deve essere presente nel form di editing di un contatto'
        );

        $form = $crawler->selectButton('Save')->form(
            array(
                // 'contact[firstName]' => 'Test Contact First name edited',
                // 'contact[lastName]' => 'Test Contact Last name edited',
                'agile_invoice_contact[title]' => 'Test title',
                'agile_invoice_contact[email]' => 'test@email.it',
                'agile_invoice_contact[phoneOffice]' => 'Test phone office',
                'agile_invoice_contact[mobile]' => 'Test mobile',
                'agile_invoice_contact[fax]' => 'Test fax',
            ),
            'PUT'
        );
        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/clients'), 'You have not been redirected to "/clients" page');

        $crawler = $client->followRedirect();

        // Testiamo l'eliminazione del contatto di test
        $link = $crawler->filter('.contact-main-info:contains("Test Contact First name Test Contact Last name")')->parents()->filter('a.edit-button')->eq(0)->link();
        $crawler = $client->click($link);

        $form = $crawler->selectButton('Save')->form(
            array(),
            'DELETE'
        );

        $crawler = $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/clients'), 'You have not been redirected to "/clients" page');

        $crawler = $client->followRedirect();

        $contact = $crawler->filter('.contact-main-info:contains("Test Contact First name Test Contact Last name")');
        $this->assertEquals(0, $contact->count(), 'Il contatto non dovrebbe esistere più');

        // Test the client select list for the add contact page
        $this->logIn('diego.armando.maradona');
        $crawler = $client->request('GET', '/clients');

        // Click on link "Buenos Aires FGCA"
        $link = $crawler->filter('a:contains("Add contact")')->last()->link();
        $crawler = $client->click($link);

        $this->assertCount(2, $crawler->filter('select#agile_invoice_contact_client > option'), 'There have to be two Client options in the add contact form');

        $this->assertCount(1, $crawler->filter('select#agile_invoice_contact_client > option:contains("Argentina Football Club")'));
        $this->assertCount(1, $crawler->filter('select#agile_invoice_contact_client > option:contains("Buenos Aires FGCA")'));

        // Check the selectd option
        $this->assertEquals('selected', $crawler->filter('select#agile_invoice_contact_client > option:contains("Buenos Aires FGCA")')->attr('selected'));

        // An archived client is not shown in add contact select list
        $crawler = $client->request('GET', '/clients');
        $crawler = $client->click($crawler->filter('a:contains("Edit")')->eq(0)->link());

        // Clicchiamo sul link per archiviare il cliente
        $crawler = $client->click($crawler->filter('a:contains("Archive")')->eq(0)->link());
        $crawler = $client->followredirect();

        // Go to add contact page:
        $crawler = $client->request('GET', '/contacts/new');
        $this->assertCount(1, $crawler->filter('select#agile_invoice_contact_client > option'), 'There has to be only one non archived Client option in the add contact form');
        $this->assertCount(0, $crawler->filter('select#agile_invoice_contact_client > option:contains("Argentina Football Club")'));


        // A company without clients cannot access the page to add new contact
        $this->logIn('michel.platini');
        $crawler = $client->request('GET', '/contacts/new');
        $this->assertTrue($client->getResponse()->isRedirect('/clients'), 'If the company has no clients has to be redirected to "/clients" page');

    }
}