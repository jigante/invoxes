<?php

namespace Agile\InvoiceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

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

        // Check the element contains an attribute with value equals "Test Client edit"
        $this->assertGreaterThan( 0, $crawler->filter('html:contains("Test Client edit")')->count() );

        // Delete the entity
        $crawler = $client->click($crawler->filter('a:contains("Edit")')->eq(0)->link());

        $form = $crawler->selectButton('Save')->form(array(), 'DELETE');

        $client->submit($form);
        
        $this->assertTrue(
            $client->getResponse()->isRedirect('/clients')
        );

        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertEquals( 0, $crawler->filter('html:contains("Test Client edit")')->count() );

    }

}