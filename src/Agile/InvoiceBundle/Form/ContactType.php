<?php

namespace Agile\InvoiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agile\InvoiceBundle\Form\EventListener\AddClientFieldSubscriber;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, array('label' => 'First name'))
            ->add('lastName', null, array('label' => 'Last name'))
            ->add('title')
            ->add('email')
            ->add('phoneOffice', null, array('label' => 'Office #'))
            ->add('mobile', null, array('label' => 'Mobile #'))
            ->add('fax', null, array('label' => 'Fax #'))
        ;

        // Mostriamo il menù a tendina per scegliere il cliente solo se il form è nuovo (no editing)
        $builder->addEventSubscriber(new AddClientFieldSubscriber());
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agile\InvoiceBundle\Entity\Contact'
        ));
    }

    public function getName()
    {
        return 'contact';
    }
}
