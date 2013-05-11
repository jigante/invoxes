<?php 

namespace Agile\InvoiceBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('current_password')
            ->remove('username')
            ->add('firstName', null, array('label' => 'registration.form.first_name'))
            ->add('lastName', null, array('label' => 'registration.form.last_name'))
            ->add('contactPhone', null, array('label' => 'registration.form.contact_phone'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agile\InvoiceBundle\Entity\User',
        ));
    }

    public function getName()
    {
        return 'agile_user_profile';
    }
}