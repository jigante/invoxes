<?php 

namespace Agile\InvoiceBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agile\InvoiceBundle\Utility\Utils as Utility;
use Symfony\Component\Intl\Intl;

class CurrencyTypeExtension extends AbstractTypeExtension
{
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return 'currency';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->getCurrencyChoices(),
            'preferred_choices' => array(
                'EUR', 'GBP', 'USD', 'CAD', 'AUD', 'NZD', 'SEK', 'DKK', 'NOK', 'CHF', 'ZAR'
            ),
        ));
    }

    private function getCurrencyChoices()
    {
        $currenySymbols = Utility::getCurrencySymbols();
        
        // \Locale::setDefault('en');
        // $currencies = Intl::getCurrencyBundle()->getCurrencyNames();
        // $currency = Intl::getCurrencyBundle()->getCurrencyName('INR');
        // $symbol = Intl::getCurrencyBundle()->getCurrencySymbol('INR');
        // $fractionDigits = Intl::getCurrencyBundle()->getFractionDigits('INR');
        // $roundingIncrement = Intl::getCurrencyBundle()->getRoundingIncrement('INR');

        $currencyChoices = array();
        foreach ($currenySymbols as $symbol) {
            $currencyName = Intl::getCurrencyBundle()->getCurrencyName($symbol);
            if ($currencyName) {
                $currencyChoices[$symbol] = $currencyName.' - '.$symbol;
            }
        }

        return $currencyChoices;
    }
}