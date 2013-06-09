<?php 

namespace Agile\InvoiceBundle\Form\Type;

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
            ->add('firstName', null, array('label' => 'form.first_name', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('lastName', null, array('label' => 'form.last_name', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('contactPhone', null, array('label' => 'form.contact_phone', 'translation_domain' => 'AgileInvoiceBundle'))
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