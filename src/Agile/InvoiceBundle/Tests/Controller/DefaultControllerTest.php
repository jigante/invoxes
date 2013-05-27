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
        $this->assertTrue($client->getResponse()->isRedirect(), 'Il cliente non è stato redirezionato verso la login page');
        // $this->assertTrue($client->getResponse()->isRedirect('login'), 'Page has not been redirected to "/login" page');

        $crawler = $client->followRedirect();

        // Click on registration button
        $link = $crawler->selectLink('Try Fatture Online for free')->link();
        $crawler = $client->click($link);

        // Register as a new user
        $form = $crawler->selectButton('Create My Account')->form(array(
            'fos_user_registration_form[firstName]' => 'MyFirstname',
            'fos_user_registration_form[lastName]' => 'MyLastname',
            'fos_user_registration_form[company]' => 'MyCompany',
            'fos_user_registration_form[email]' => 'myfirstname@mylastname.it',
            'fos_user_registration_form[contactPhone]' => '079782435647689273',
            'fos_user_registration_form[username]' => 'myfirstname',
            'fos_user_registration_form[plainPassword][first]' => 'pwd981',
            'fos_user_registration_form[plainPassword][second]' => 'pwd981',
        ));

        $client->submit($form);

        $this->assertTrue(
            $client->getResponse()->isRedirect('/'),
            'Page has not been redirected to "home" page'
        );
        $crawler = $client->followRedirect();

        $this->assertTrue(
            $client->getResponse()->isRedirect('/welcome'),
            'Page has not been redirected to Welcome page'
        );
        $crawler = $client->followRedirect();

        $this->assertTrue(
            $crawler->filter('html:contains("Hello, MyFirstname!")')->count() > 0,
            'Html doesn\'t contain "Hello, MyFirstname"'
        );

        $this->assertTrue($crawler->filter(
            'html:contains("Here are a few simple steps to get started")')->count() > 0,
            'Html doesn\'t contain "Here are a few simple steps to get started"'
        );

        // Verify it's not possible access overview page when welcome screen is still not disabled
        $crawler = $client->request('GET', '/overview');
        $this->assertTrue(
            $client->getResponse()->isRedirect('/welcome'),
            'Page has not ben redirected to welcome page'
        );
        $crawler = $client->followRedirect();

        // Verify it's not possible to hide a welcome screen for a different usera than the one logged in
        $crawler = $client->request('GET', '/user/999999/disable_welcome_screen');
        $this->assertTrue(
            $client->getResponse()->isNotFound(),
            'It\'s not possible to edit a different user'
        );

        // Return to welcome page
        $crawler = $client->request('GET', '/welcome');

        // Click the "Hide welcome screen"
        $link = $crawler->selectLink('Hide it!')->link();
        $crawler = $client->click($link);

        // Follow redirect to home page
        $this->assertTrue(
            $client->getResponse()->isRedirect('/'),
            'Page has not ben redirected to home page'
        );
        $crawler = $client->followRedirect();

        // Follow redirect to overview page
        $this->assertTrue(
            $client->getResponse()->isRedirect('/overview'),
            'Page has not ben redirected to overview page'
        );
        $crawler = $client->followRedirect();

        $this->assertTrue(
            $crawler->filter('html:contains("Dashboard")')->count() > 0,
            'Html doesn\'t contain "Dashboard"'
        );

        // Verify it's not possible access welcome page when welcome screen is disabled
        $crawler = $client->request('GET', '/welcome');
        $this->assertTrue(
            $client->getResponse()->isRedirect('/overview'),
            'Page has not ben redirected to overview page'
        );
        $crawler = $client->followRedirect();

    }
}
