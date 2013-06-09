<?php

namespace Agile\InvoiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionResolver\OptionResolverInterface;

class CompanyPreferencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'form.company_name', 'translation_domain' => 'AgileInvoiceBundle'))
        ;
    }

    public function getName()
    {
        return 'company_preferences';
    }

    public function setDefaultOptions(OptionResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agile\InvoiceBundle\Entity\Company';
        ));
    }

}