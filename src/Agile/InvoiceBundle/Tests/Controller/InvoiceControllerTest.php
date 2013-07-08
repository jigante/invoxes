<?php

namespace Agile\InvoiceBundle\Tests\Controller;

use Agile\InvoiceBundle\Tests\TestCase;

class InvoiceControllerTest extends TestCase
{

    public function testIndex()
    {
        $client = $this->client;

        $this->logIn();

        $crawler = $client->request('GET', '/invoices');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /invoices/");

        // At beginning the "Invoices" tips is visible
        $showTipsLink = $crawler->filter('div.tips > a.show');
        $this->assertEquals(
            'display:none;',
            $showTipsLink->attr('style'),
            'The attribute "style" for the "show tips link" link has to be "display:none"'
        );

        $this->assertEquals(
            'Page Tips',
            $showTipsLink->text(),
            'The content of the "show tips link" has to be "Page Tips"'
        );

        $tips = $crawler->filter('div.tips > div.alert');
        $this->assertEquals(
            'display:block;',
            $tips->attr('style'),
            'The attribute "style" for the "tips" has to be "display:block"'
        );

        $this->assertGreaterThan(
            0,
            $tips->filter('h5:contains("Tip: Invoicing")')->count(),
            'The "tips" div has to contain "Tip: Invoicing"'
        );

    }

    public function testFirstStepInvoiceForm()
    {
        $client = $this->client;

        $this->logIn();

        $crawler = $client->request('GET', '/invoices');

        // Contains only 2 clients, the active ones
        $this->assertEquals(2, $crawler->filter('div#agile_invoice_invoice_first_step select option')->count());
        $this->assertEquals(1, $crawler->filter('option:contains("Catania FGCI")')->count());
        $this->assertEquals(1, $crawler->filter('option:contains("Inter FGCI")')->count());

        // Des not contain archived clients
        $this->assertEquals(0, $crawler->filter('option:contains("Palermo FGCI")')->count());

        // Des not contain clients from other companies
        $this->assertEquals(0, $crawler->filter('option:contains("Argentina Football Club")')->count());

    }


    public function testInvoiceTips()
    {
        $client = $this->client;

        $this->logIn();

        // Disable invoice tips
        $crawler = $client->request(
            'GET', '/users/settings/xhr/disable_invoice_page_tips/1',
            array(), array(), array(
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            )
        );

        // Verify if when opening again the page, they are hidden
        // Because of the setting written in the DB
        $crawler = $client->request('GET', '/invoices');

        $showTipsLink = $crawler->filter('div.tips > a.show');
        $this->assertEquals(
            'display:block;',
            $showTipsLink->attr('style'),
            'The attribute "style" for the "show tips link" link has to be "display:block"'
        );

        $tips = $crawler->filter('div.tips > div.alert');
        $this->assertEquals(
            'display:none;',
            $tips->attr('style'),
            'The attribute "style" for the "tips" has to be "display:none"'
        );

        // Enable again invoice tips
        $crawler = $client->request(
            'GET', '/users/settings/xhr/disable_invoice_page_tips/0',
            array(), array(), array(
                'HTTP_X-Requested-With' => 'XMLHttpRequest',
            )
        );

        $crawler = $client->request('GET', '/invoices');

        $showTipsLink = $crawler->filter('div.tips > a.show');
        $this->assertEquals(
            'display:none;',
            $showTipsLink->attr('style'),
            'The attribute "style" for the "show tips link" link has to be "display:none"'
        );

        $tips = $crawler->filter('div.tips > div.alert');
        $this->assertEquals(
            'display:block;',
            $tips->attr('style'),
            'The attribute "style" for the "tips" has to be "display:block"'
        );
    }
}
