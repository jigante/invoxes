<?php 

namespace Agile\InvoiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class InvoiceFirstStepFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder->add('client', 'entity', array(
            'label' => 'which.client.is.the.invoice.for',
            'class' => 'AgileInvoiceBundle:Client',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->where('c.archived = :archived')
                    ->setParameter('archived', 0)
                    ->orderBy('c.name', 'ASC');
            },
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agile\InvoiceBundle\Entity\Invoice',
        ));   
    }

    public function getName()
    {
        return 'agile_invoice_invoice_first_step';
    }

}