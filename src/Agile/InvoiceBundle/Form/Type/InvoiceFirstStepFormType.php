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
        $company = $option['company'];

        $builder->add('client', 'entity', array(
            'label' => 'which.client.is.the.invoice.for',
            'class' => 'AgileInvoiceBundle:Client',
            'query_builder' => function(EntityRepository $er) use ($company) {
                return $er->createQueryBuilder('c')
                    ->where('c.archived = :archived')
                    ->andWhere('c.company = :company')
                    ->setParameters(array('archived' => 0, 'company' => $company))
                    ->orderBy('c.name', 'ASC');
            },
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agile\InvoiceBundle\Entity\Invoice',
        ));

        $resolver->setRequired(array('company'));
    }

    public function getName()
    {
        return 'agile_invoice_invoice_first_step';
    }

}