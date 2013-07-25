<?php 

namespace Agile\InvoiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class InvoiceFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $company = $options['company'];

        $builder
            ->add('client', new CompanyClientFormType(), array(
                'company' => $company
            ))
        ;        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agile\InvoiceBundle\Entity\Invoice',
            'cascade_validation' => true,
        ));

        $resolver->setRequired(array('company'));
    }

    public function getName()
    {
        return 'agile_invoice_invoice';
    }

}