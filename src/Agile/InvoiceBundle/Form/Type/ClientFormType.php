<?php

namespace Agile\InvoiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Check if the client object is new
        // to show the account default currency
        if (!$options['data']->getId() /*isNew()*/) {
            $viewAccountDefaultCurrency = $options['data']->getCurrency();
        } else {
            $viewAccountDefaultCurrency = null;
        }         

        $builder
            ->add('name')
            ->add('address', 'textarea', array('required' => false))
            ->add('currency', 'currency', array(
                'label' => 'preferred.currency',
                'view_account_default_currency' => $viewAccountDefaultCurrency,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agile\InvoiceBundle\Entity\Client'
        ));
    }

    public function getName()
    {
        return 'agile_invoice_client';
    }
}
