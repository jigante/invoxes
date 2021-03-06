<?php

namespace Agile\InvoiceBundle\Tests\Controller;

use Agile\InvoiceBundle\Tests\TestCase;

class ClientControllerTest extends TestCase
{

    public function testCompleteScenario()
    {

        // Get the client to browse the application
        $client = $this->client;

        // Login as "walter.zenga"
        $this->logIn();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/clients');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /clients/");

        $this->assertGreaterThan(
            0,
            $crawler->filter('a:contains("+ Add Contact")')->count(),
            'A company with clients has the button "+ Add Contact" in the index client page'
        );

        $this->assertEquals(1, $crawler->filter('html:contains("Inter FGCI")')->count(), "User 'Walter Zenga' needs to have 'Inter FGCI' in its client list");

        $this->assertEquals(0, $crawler->filter('html:contains("Argentina Football Club")')->count(), "User 'Walter Zenga' has not to have 'Argentina Football Club' in its client list");

        $crawler = $client->click($crawler->selectLink('+ Create Client')->link());

        $this->assertEquals(1, $crawler->filter('option:contains("Account default (Euro - EUR)")')->count(), "The default option does not conain 'Account default...' suggestion");

        // Fill in the form and submit it
        $form = $crawler->selectButton('Save')->form(array(
            'agile_invoice_client[name]'  => 'A.C. Verona',
            'agile_invoice_client[address]'  => "via Venezia, 11\n08100 Verona (VR)",
            'agile_invoice_client[currency]'  => "GBP",
        ));

        $client->submit($form);
        
        $this->assertTrue(
            $client->getResponse()->isRedirect('/clients')
        );

        $crawler = $client->followRedirect();

        $this->assertGreaterThan( 0, $crawler->filter('html:contains("A.C. Verona")')->count() );

        // Edit the entity
        $crawler = $client->click($crawler->filter('a:contains("Edit")')->eq(0)->link());

        $this->assertGreaterThan( 0, $crawler->filter('html:contains("Edit Client")')->count() );

        $this->assertEquals(0, $crawler->filter('option:contains("Account default (Euro - EUR)")')->count(), "The default option conains 'Account default...' suggestion");

        $form = $crawler->selectButton('Save')->form(
            array(
                'agile_invoice_client[name]'  => 'A.C. Hellas Verona',
                'agile_invoice_client[address]'  => "via Venezia, 12\n08200 Verona (VR)",
                'agile_invoice_client[currency]'  => "EUR",
                ),
            'PUT'
        );

        $client->submit($form);
        
        $this->assertTrue(
            $client->getResponse()->isRedirect('/clients')
        );

        $crawler = $client->followRedirect();

        // Check that html contains "Verona Calcio FGCI"
        $this->assertGreaterThan( 0, $crawler->filter('html:contains("A.C. Hellas Verona")')->count() );

        // Archive the entity
        // Andiamo prima nella pagina di editing del cliente di test
        $crawler = $client->click($crawler->filter('a:contains("Edit")')->eq(0)->link());

        // Clicchiamo sul link per archiviare il cliente
        $crawler = $client->click($crawler->filter('a:contains("Archive")')->eq(0)->link());

        $this->assertTrue(
            $client->getResponse()->isRedirect('/clients')
        );

        $crawler = $client->followredirect();

        // Ora la pagina indice dei clienti contiene il link "Manage Archived Clients"
        $this->assertGreaterThan( 0, $crawler->filter('a:contains("Manage Archived Clients")')->count() );

        // De-archive the entity
        // Andiamo nella pagina dei clienti archiviati
        $crawler = $client->click($crawler->filter('a:contains("Manage Archived Clients")')->eq(0)->link());

        $this->assertGreaterThan(0, $crawler->filter('ul.clients-list-inactive li a')->count());

        $link = $crawler->filter('ul.clients-list-inactive li a')->eq(0)->link();

        // First verify that a user cannot toggle a client that belongs to another user

        // There has not to be the link "Manage Archived Clients" for anoter user, too
        $this->logIn('diego.armando.maradona');
        $crawler = $client->request('GET', '/clients');
        $this->assertEquals( 0, $crawler->filter('a:contains("Manage Archived Clients")')->count() );

        $crawler = $client->request('GET', $link->getUri());
        $this->assertTrue(
            $client->getResponse()->isNotFound(),
            'A user cannot toggle the client that belongs to a different user'
        );
        // var_dump($crawler); exit;

        // Continue with the default user
        $this->logIn();
        $crawler = $client->request('GET', '/clients');

        $crawler = $client->click($link);

        $this->assertTrue(
            $client->getResponse()->isRedirect('/clients'),
            'After de-archiving of client the page has to be redirected to "/clients"'
        );

        $crawler = $client->followredirect();

        // The entity "client" can't be deleted when it has contacts
        $crawler = $client->click($crawler->filter('a:contains("Edit")')->eq(2)->link());

        $this->assertGreaterThan(0, $crawler->filter('em:contains("You cannot remove ")')->count());
        $this->assertEquals(0, $crawler->filter('a:contains("Remove ")')->count());

        // So try to delete a client without contacts (the last client)
        $crawler = $client->request('GET', '/clients');

        $crawler = $client->click($crawler->filter('a:contains("Edit")')->eq(0)->link());

        $this->assertGreaterThan(0, $crawler->filter('a:contains("Remove ")')->count());
        $this->assertEquals(0, $crawler->filter('em:contains("You cannot remove ")')->count());

        //Delete the entity
        $form = $crawler->selectButton('Save')->form(array(), 'DELETE');
        $client->submit($form);
        // var_dump($client->getResponse()); exit;

        $this->assertTrue(
            $client->getResponse()->isRedirect('/clients'),
            'After deletion of client the page has to be redirected to "/clients"'
        );

        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertEquals( 0, $crawler->filter('html:contains("Walter Zenga edit")')->count() );


        // Cannot create a new client with the same name of another client for the actual user
        $crawler = $client->request('GET', '/clients');

        $crawler = $client->click($crawler->selectLink('+ Create Client')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Save')->form(array(
            'agile_invoice_client[name]'  => 'Inter FGCI',
        ));

        $crawler = $client->submit($form);

        $this->assertGreaterThan(
            0,
            $crawler->filter('li.help-inline:contains("Name has already been taken")')->count()
        );

        // But a client with the same name can be created for a different user
        $this->logIn('diego.armando.maradona');

        $crawler = $client->request('GET', '/clients');
        
        $crawler = $client->click($crawler->selectLink('+ Create Client')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Save')->form(array(
            'agile_invoice_client[name]'  => 'Inter FGCI',
        ));

        $client->submit($form);

        $this->assertTrue(
            $client->getResponse()->isRedirect('/clients')
        );

        $crawler = $client->followRedirect();

        // Check the client is in the list of clients
        $this->assertGreaterThan( 0, $crawler->filter('html:contains("Inter FGCI")')->count() );

        // A company without clients cannot see the button "+ Add Contact" in the index client page
        $this->logIn('michel.platini');

        $crawler = $client->request('GET', '/clients');
        $this->assertEquals(
            0,
            $crawler->filter('a:contains("+ Add Contact")')->count(),
            'A company without clients cannot see the button "+ Add Contact" in the index client page'
        );

    }

}