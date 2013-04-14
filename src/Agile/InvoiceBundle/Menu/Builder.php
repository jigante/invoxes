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
        $menu->addChild('Fatture', array('route' => 'invoices'));
        $menu->addChild('Report', array('route' => 'invoices_archive'));
        $menu->addChild('Clienti', array('route' => 'clients'));
        $menu->addChild('Progetti', array('route' => 'projects'));
        $menu->addChild('Ricorrenti', array('route' => 'recurring_invoices'));
        $menu->addChild('Preventivi', array('route' => 'estimates'));
        $menu->addChild('Configura', array('route' => 'invoices_configure'));

        return $menu;
    }
}