<?php 

namespace Agile\InvoiceBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('firstName', null, array('label' => 'registration.form.first_name'))
            ->add('lastName', null, array('label' => 'registration.form.last_name'))
            ->add('contactPhone', null, array('label' => 'registration.form.contact_phone'))
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