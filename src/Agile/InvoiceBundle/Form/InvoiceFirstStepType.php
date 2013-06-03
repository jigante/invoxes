<?php 

namespace Agile\InvoiceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class InvoiceFirstStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder->add('client', 'entity', array(
            // 'label' => $this->get('translator')->trans('which.client.is.the.invoice.for'),
            'class' => 'AgileInvoiceBundle:Client',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
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
        return 'invoice_first_step';
    }

}