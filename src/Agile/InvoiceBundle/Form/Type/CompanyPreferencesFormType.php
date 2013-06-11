<?php

namespace Agile\InvoiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class CompanyPreferencesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $company = $options['data'];
        $builder
            ->add('name', 'text', array('label' => 'company.name', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('owner', 'entity', array(
                'required' => true,
                'label' => 'company.account_owner',
                'translation_domain' => 'AgileInvoiceBundle',
                'class' => 'AgileInvoiceBundle:User',
                'property' => 'choicheListName',
                'query_builder' => function(EntityRepository $er) use ($company) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.firstName', 'ASC')
                        ->where('u.company = :company')
                        ->setParameter('company', $company)
                    ;
                }
            ))
            ->add('fiscalYearStart', null, array('label' => 'company.fiscal_year', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('timezone', null, array('label' => 'company.timezone', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('dateFormat', null, array('label' => 'company.date_format', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('currency', null, array('label' => 'company.currency', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('currencyPlacement', null, array('label' => 'company.currency_placement', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('includeCurrencyCode', null, array('label' => 'company.include_currency_code', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('numberFormat', null, array('label' => 'company.number_format', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('colorScheme', null, array('label' => 'company.color_scheme', 'translation_domain' => 'AgileInvoiceBundle'))
            ->add('logo', null, array('label' => 'company.logo', 'translation_domain' => 'AgileInvoiceBundle'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agile\InvoiceBundle\Entity\Company',
        ));
    }

    public function getName()
    {
        return 'agile_invoice_company_preferences';
    }

}