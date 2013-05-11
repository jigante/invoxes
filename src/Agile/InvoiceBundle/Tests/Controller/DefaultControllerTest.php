<?php

namespace Agile\InvoiceBundle\Tests\Controller;

use Agile\InvoiceBundle\Tests\TestCase;

class DefaultControllerTest extends TestCase
{

    public function testIndex()
    {
        // Get the client to browse the application
        $client = $this->client;

        $crawler = $client->request('GET', '/');

        // The first time we access the home page, the client is redirected to login page
        $this->assertTrue($client->getResponse()->isRedirect());
        // $this->assertTrue($client->getResponse()->isRedirect('login'), 'Page has not been redirected to "/login" page');

        $crawler = $client->followRedirect();

        // Click on registration button
        $link = $crawler->selectLink('Try Fatture Online for free')->link();
        $crawler = $client->click($link);

        // Register as a new user
        $form = $crawler->selectButton('create.my.account')->form(array(
            'fos_user_registration_form[firstName]' => 'Cristiano',
            'fos_user_registration_form[lastName]' => 'Santeramo',
            'fos_user_registration_form[company]' => 'Agile VPS',
            'fos_user_registration_form[email]' => 'cristiano@agileweb.it',
            'fos_user_registration_form[contactPhone]' => '07955588592',
            'fos_user_registration_form[username]' => 'jigante',
            'fos_user_registration_form[plainPassword][first]' => 'testpassword',
            'fos_user_registration_form[plainPassword][second]' => 'testpassword',
        ));

        $client->submit($form);

        $this->assertTrue(
            $client->getResponse()->isRedirect('/'),
            'Page has not been redirected to "home" page'
        );

        $crawler = $client->followRedirect();

        $this->assertTrue($crawler->filter('html:contains("Hello, Cristiano!")')->count() > 0);

        $this->assertTrue($crawler->filter('html:contains("Here are a few simple steps to get started")')->count() > 0);
    }
}
