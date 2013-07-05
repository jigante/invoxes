<?php 

namespace Agile\InvoiceBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Agile\InvoiceBundle\Utility\Utils as Utility;
use Symfony\Component\Intl\Intl;

class CurrencyTypeExtension extends AbstractTypeExtension
{
    private $translator;

    public function __construct($translator)
    {
        $this->translator = $translator;
    }

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
            'choices' => function (Options $options) {
                return $this->getCurrencyChoices($options['view_account_default_currency']);
            },
            'preferred_choices' => array(
                'EUR', 'GBP', 'USD', 'CAD', 'AUD', 'NZD', 'SEK', 'DKK', 'NOK', 'CHF', 'ZAR'
            ),
            'view_account_default_currency' => null,
        ));

    }

    private function getCurrencyChoices($viewAccountDefaultCurrency = null)
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
                $currencyValue = $currencyName.' - '.$symbol;
                if ($viewAccountDefaultCurrency == $symbol) {
                    $currencyChoices[$symbol] = $this->translator->trans(
                        'account.default.%currencyValue%',
                        array('%currencyValue%' => $currencyValue)
                    );
                } else {
                    $currencyChoices[$symbol] = $currencyValue;
                }
                
            }
        }

        return $currencyChoices;
    }
}