<?php

namespace Agile\InvoiceBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
use Agile\InvoiceBundle\Entity\Company;

class AddClientFieldSubscriber implements EventSubscriberInterface
{
    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        // var_dump($form); exit;

        // check if the contact object is new
        if (!$data || !$data->getId()) {
            $form->add('client', 'entity', array(
                'label' => 'form.client',
                'translation_domain' => 'AgileInvoiceBundle',
                'class' => 'AgileInvoiceBundle:Client',
                'query_builder' => function(EntityRepository $er) {
                    $queryBuilder = $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC')
                        ->where('c.company = :company')
                        ->andWhere('c.archived = 0')
                        ->setParameter('company', $this->company)
                    ;

                    return $queryBuilder;
                    // return $er->findActiveClientsQueryBuilder($this->company);
                },
            ));
        }
    }
}