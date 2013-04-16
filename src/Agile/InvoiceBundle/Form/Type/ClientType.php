<?php 

namespace Agile\InvoiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

// While not always necessary, it's generally a good idea to explicitly specify the data_class option
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $builder->add('id', 'hidden');
        $builder->add('name');
        $builder->add('address', 'textarea', array('required' => false));
        $builder->add('currency', 'hidden');
    }

    public function getName()
    {
        return 'client';
    }

    // While not always necessary, it's generally a good idea to explicitly specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agile\InvoiceBundle\Entity\Client',
        ));
    }
}