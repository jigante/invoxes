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
        $form = $crawler->selectButton('create.my.account')->form(array(
            'fos_user_registration_form[firstName]' => 'MyFirstname',
            'fos_user_registration_form[lastName]' => 'MyLastname',
            'fos_user_registration_form[company]' => 'MyCompany',
            'fos_user_registration_form[email]' => 'myfirstname@mylastname.it',
            'fos_user_registration_form[contactPhone]' => '079782435647689273',
            'fos_user_registration_form[username]' => 'myfirstname',
            'fos_user_registration_form[plainPassword][first]' => 'testpassword',
            'fos_user_registration_form[plainPassword][second]' => 'testpassword',
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

        $this->assertTrue($crawler->filter('html:contains("Hello, MyFirstname!")')->count() > 0);

        $this->assertTrue($crawler->filter('html:contains("Here are a few simple steps to get started")')->count() > 0);
    }
}
