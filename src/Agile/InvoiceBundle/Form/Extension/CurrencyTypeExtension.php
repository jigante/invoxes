<?php 

namespace Agile\InvoiceBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
        $currenySymbols =  array(
            'AED',    'AFN',    'ALL',
            'AMD',    'ANG',    'AOA',
            'ARS',    'AUD',    'AWG',
            'AZN',    'BAM',    'BBD',
            'BDT',    'BGN',    'BHD',
            'BIF',    'BMD',    'BND',
            'BOB',    'BRL',    'BSD',
            'BTN',    'BWP',    'BYR',
            'BZD',    'CAD',    'CDF',
            'CHF',    'CLP',    'CNY',
            'COP',    'CRC',    'CUC',
            'CUP',    'CVE',    'CZK',
            'DJF',    'DKK',    'DOP',
            'DZD',    'EGP',    'ERN',
            'ETB',    'EUR',    'FJD',
            'FKP',    'GBP',    'GEL',
            'GGP',    'GHS',    'GIP',
            'GMD',    'GNF',    'GTQ',
            'GYD',    'HKD',    'HNL',
            'HRK',    'HTG',    'HUF',
            'IDR',    'ILS',    'IMP',
            'INR',    'IQD',    'IRR',
            'ISK',    'JEP',    'JMD',
            'JOD',    'JPY',    'KES',
            'KGS',    'KHR',    'KMF',
            'KPW',    'KRW',    'KWD',
            'KYD',    'KZT',    'LAK',
            'LBP',    'LKR',    'LRD',
            'LSL',    'LTL',    'LVL',
            'LYD',    'MAD',    'MDL',
            'MGA',    'MKD',    'MMK',
            'MNT',    'MOP',    'MRO',
            'MUR',    'MVR',    'MWK',
            'MXN',    'MYR',    'MZN',
            'NAD',    'NGN',    'NIO',
            'NOK',    'NPR',    'NZD',
            'OMR',    'PAB',    'PEN',
            'PGK',    'PHP',    'PKR',
            'PLN',    'PYG',    'QAR',
            'RON',    'RSD',    'RUB',
            'RWF',    'SAR',    'SBD',
            'SCR',    'SDG',    'SEK',
            'SGD',    'SHP',    'SLL',
            'SOS',    'SPL',    'SRD',
            'STD',    'SVC',    'SYP',
            'SZL',    'THB',    'TJS',
            'TMT',    'TND',    'TOP',
            'TRY',    'TTD',    'TVD',
            'TWD',    'TZS',    'UAH',
            'UGX',    'USD',    'UYU',
            'UZS',    'VEF',    'VND',
            'VUV',    'WST',    'XAF',
            'XCD',    'XDR',    'XOF',
            'XPF',    'YER',    'ZAR',
            'ZMK',
        );
        
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