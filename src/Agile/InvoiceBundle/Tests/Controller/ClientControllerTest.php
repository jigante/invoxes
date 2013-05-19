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
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /client/");
        $crawler = $client->click($crawler->selectLink('+ Create Client')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Save')->form(array(
            'client[name]'  => 'Test Client',
            'client[address]'  => 'Test Client address',
        ));

        $client->submit($form);
        
        $this->assertTrue(
            $client->getResponse()->isRedirect('/clients')
        );

        $crawler = $client->followRedirect();

        // Ora la pagina indice dei clienti non contiene il link "Manage Archived Clients"
        $this->assertEquals( 0, $crawler->filter('a:contains("Manage Archived Clients")')->count() );

        $this->assertGreaterThan( 0, $crawler->filter('html:contains("Test Client")')->count() );

        // Edit the entity
        $crawler = $client->click($crawler->filter('a:contains("Edit")')->eq(0)->link());

        $this->assertGreaterThan( 0, $crawler->filter('html:contains("Edit Client")')->count() );

        $form = $crawler->selectButton('Save')->form(
            array(
                'client[name]'  => 'Test Client edit',
                'client[address]'  => 'Test Client address edit',
                ),
            'PUT'
        );

        $client->submit($form);
        
        $this->assertTrue(
            $client->getResponse()->isRedirect('/clients')
        );

        $crawler = $client->followRedirect();

        // Check that html contains "Test Client edit"
        $this->assertGreaterThan( 0, $crawler->filter('html:contains("Test Client edit")')->count() );

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

        $crawler = $client->click($crawler->filter('ul.clients-list-inactive li a')->eq(0)->link());

        $this->assertTrue(
            $client->getResponse()->isRedirect('/clients')
        );

        $crawler = $client->followredirect();

        // Delete the entity
        $crawler = $client->click($crawler->filter('a:contains("Edit")')->eq(0)->link());

        $form = $crawler->selectButton('Save')->form(array(), 'DELETE');

        $client->submit($form);
        
        $this->assertTrue(
            $client->getResponse()->isRedirect('/clients')
        );

        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertEquals( 0, $crawler->filter('html:contains("Walter Zenga edit")')->count() );

    }

}