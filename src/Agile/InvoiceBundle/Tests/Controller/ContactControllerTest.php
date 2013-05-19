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
            'client[name]' => 'Test Client for contact',
            'client[address]' => 'Address of Test Client for contact'
        ));

        $crawler = $client->submit($form);

        $crawler = $client->followRedirect();

        // So now we again in "/clients" page and can start adding a Contact
        $link = $crawler->selectLink('+ Add Contact')->link();

        $this->assertRegExp('/\/contacts\/new/', $link->getUri());

        $crawler = $client->click($link);

        $this->assertRegExp('/Add Contact/', $client->getResponse()->getContent());

        $form = $crawler->selectButton('Save')->form();

        // Testiamo l'invio del form vuoto
        $crawler = $client->submit($form);

        // Dobbiamo avere due messaggi di errore "This value should not be blank."
        $formErrors = $crawler->filter('li.help-inline:contains("This value should not be blank.")');
        $this->assertEquals(2, $formErrors->count());

        // Send again the form only with First name and Last Name
        $form = $crawler->selectButton('Save')->form(array(
            'contact[firstName]' => 'Test Contact First name',
            'contact[lastName]' => 'Test Contact Last name'
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
                'contact[title]' => 'Test title',
                'contact[email]' => 'test@email.it',
                'contact[phoneOffice]' => 'Test phone office',
                'contact[mobile]' => 'Test mobile',
                'contact[fax]' => 'Test fax',
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

    }
}