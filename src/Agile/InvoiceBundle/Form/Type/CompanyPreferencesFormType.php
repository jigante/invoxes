<?php

namespace Agile\InvoiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Agile\InvoiceBundle\Utility\Utils as Utility;

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
                'choices' => Utility::getMonths(),
            ))
            ->add('timezone', 'choice', array(
                'label' => 'company.timezone',
                'choices' => Utility::getTimezones(),
                'preferred_choices' => array(
                    'Europe/Rome',
                    'Europe/London',
                ),
            ))
            ->add('dateFormat', 'choice', array(
                'label' => 'company.date_format',
                'choices' => Utility::getDateFormats(),

            ))
            ->add('currency', 'currency', array(
                'label' => 'company.currency',
            ))
            ->add('currencyPlacement', 'choice', array(
                'label' => 'company.currency_placement',
                'choices' => array(
                    '1' => 'company.currency_placement.before_text',
                    '0' => 'company.currency_placement.after_text',
                ),
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('includeCurrencyCode', 'choice', array(
                'label' => 'company.include_currency_code',
                'choices' => array(
                    '1' => 'company.currency_code_suffix.always_include',
                    '0' => 'company.currency_code_suffix.never_include',
                ),
                'expanded' => true,
                'multiple' => false,  
            ))
            ->add('numberFormat', 'choice', array(
                'label' => 'company.number_format',
                'choices' => Utility::getNumberFormats(),
                'expanded' => true,
                'multiple' => false,

            ))
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