<?php

namespace Agile\InvoiceBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    
    public function topMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('topMenu');
        $menu->setChildrenAttribute('class', 'nav');

        $menu->addChild('Home', array('route' => 'home'));
        $menu->addChild('Invoices', array('route' => 'invoice'));
        $menu->addChild('Report', array('route' => 'invoice_archive'));

        $menu->addChild('Clients', array('route' => 'client'));
        $menu['Clients']->addChild('Create New Client', array('route' => 'client_new'));
        $menu['Clients']->setDisplayChildren(false);

        $menu->addChild('Projects', array('route' => 'projects'));
        $menu->addChild('Recurring', array('route' => 'recurring_invoices'));
        $menu->addChild('Estimates', array('route' => 'estimates'));
        $menu->addChild('Configure', array('route' => 'invoice_configure'));

        return $menu;
    }
}