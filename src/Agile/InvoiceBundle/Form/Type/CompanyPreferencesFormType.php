<?php

namespace Agile\InvoiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Agile\InvoiceBundle\Utility;

class CompanyPreferencesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $company = $options['data'];
        $builder
            ->add('name', 'text', array('label' => 'company.name'))
            ->add('owner', 'entity', array(
                'label' => 'company.account_owner',
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
            ->add('fiscalYearStart', 'choice', array(
                'label' => 'company.fiscal_year',
                'choices' => $company->getFiscalYearChoiches(),
            ))
            ->add('timezone', 'choice', array(
                'label' => 'company.timezone',
                'choices' => Utility::getTimezones(),
                'preferred_choices' => array(
                    'Europe/Rome',
                    'Europe/London',
                ),
            ))
            ->add('dateFormat', null, array('label' => 'company.date_format'))
            ->add('currency', null, array('label' => 'company.currency'))
            ->add('currencyPlacement', null, array('label' => 'company.currency_placement'))
            ->add('includeCurrencyCode', null, array('label' => 'company.include_currency_code'))
            ->add('numberFormat', null, array('label' => 'company.number_format'))
            ->add('colorScheme', null, array('label' => 'company.color_scheme'))
            ->add('logo', null, array('label' => 'company.logo'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Agile\InvoiceBundle\Entity\Company',
            'validation_groups' => array('Preferences'),
        ));
    }

    public function getName()
    {
        return 'agile_invoice_company_preferences';
    }

}