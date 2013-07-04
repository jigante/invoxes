<?php

namespace Agile\InvoiceBundle\Tests\Controller;

use Agile\InvoiceBundle\Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    public function testCompleteScenario()
    {
        // Get the client to browse the application
        $client = $this->client;

        // Login as "walter.zenga"
        $this->logIn();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/company/account');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /company/account");

        // Verify all the the defaults data for company preferences are set
        $this->assertEquals(11, $crawler->filter('dl.settings-list dd')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("Walter Zenga LTD")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("Walter Zenga")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("Starts in January")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("London")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("'.date('d/m/Y').'")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("Euro - EUR")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("1.234,56")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("Place before the amount")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("Never include currency code suffix")')->count());

        // Modify some data via preferences form and verify the settings are read correctly
        $crawler = $client->click($crawler->selectLink('Edit Preferences')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Save Preferences')->form(array(
            'agile_invoice_company_preferences[fiscalYearStart]' => 4,
            'agile_invoice_company_preferences[timezone]' => 'Europe/Rome',
            'agile_invoice_company_preferences[dateFormat]' => 'Y/m/d',
            'agile_invoice_company_preferences[currency]' => 'GBP',
            'agile_invoice_company_preferences[currencyPlacement]' => 0,
            'agile_invoice_company_preferences[includeCurrencyCode]' => 1,
            'agile_invoice_company_preferences[numberFormat]' => '&#x27;.',
        ));

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/company/account'));

        $crawler = $client->followRedirect();

        // Verify all the modified data have been correcly written in DB
        // Use the first 2 to be sure that form submissions does not alters Company name and account owner
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("Walter Zenga LTD")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("Walter Zenga")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("Starts in April")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("Rome")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("'.date('Y/m/d').'")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("British Pound Sterling - GBP")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("1\'234.56")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("Place after the amount")')->count());
        $this->assertGreaterThan(0, $crawler->filter('dd:contains("Always include currency code suffix")')->count());
        
    }
}