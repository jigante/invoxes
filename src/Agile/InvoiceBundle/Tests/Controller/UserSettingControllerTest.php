<?php

namespace Agile\InvoiceBundle\Tests\Controller;

use Agile\InvoiceBundle\Tests\TestCase;

class UserSettingControllerTest extends TestCase
{

    public function testSetAjaxUserSetting()
    {
        $client = $this->client;

        $this->logIn();
        
        // If we don't call the url to disable page tips via ajax, receive a not found response
        $crawler = $client->request('GET', '/users/settings/xhr/disable_invoice_page_tips/1');
        $this->assertTrue(
            $client->getResponse()->isNotFound(),
            'It\'s not possible to call the url to disable and enable page urls without ajax request'
        );

    }

}