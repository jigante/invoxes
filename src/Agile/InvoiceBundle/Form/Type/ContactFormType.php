<?php

namespace Agile\InvoiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agile\InvoiceBundle\Form\EventListener\AddClientFieldSubscriber;
use Agile\InvoiceBundle\Entity\Company;

class ContactFormType extends AbstractType
{
    protected $company;

    public function __construct(Company $company = null)
    {
        $this->company = $company;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, array('label' => 'form.first_name'))
            ->add('lastName', null, array('label' => 'form.last_name'))
            ->add('title')
            ->add('email')
            ->add('phoneOffice', null, array('label' => 'form.office_number'))
            ->add('mobile', null, array('label' => 'form.mobile_number'))
            ->add('fax', null, array('label' => 'form.fax_number'))
        ;

        // Mostriamo il menù a tendina per scegliere il cliente solo se il form è nuovo (no editing)
        if ($this->company ) {
            $builder->addEventSubscriber(new AddClientFieldSubscriber($this->company));
        }
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agile\InvoiceBundle\Entity\Contact'
        ));
    }

    public function getName()
    {
        return 'agile_invoice_contact';
    }
}
