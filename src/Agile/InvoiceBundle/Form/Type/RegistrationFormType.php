<?php 

namespace Agile\InvoiceBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('firstName', null, array('label' => 'form.first_name', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('lastName', null, array('label' => 'form.last_name', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('contactPhone', null, array('label' => 'form.contact_phone', 'translation_domain' => 'AgileInvoiceBundle'))
        ;

        $builder->add('company', new CompanyType());
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agile\InvoiceBundle\Entity\User',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'agile_user_registration';
    }
}