<?php 

namespace Agile\InvoiceBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Client
{
    /**
     * @Assert\NotBlank();
     */
    protected $name;

    /**
     * @Assert\NotBlank();
     */
    protected $address;

    protected $currency;

    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }

    public function getAddress() {
        return $this->address;
    }
    
    public function setAddress($address) {
        $this->address = $address;
    }

    public function getCurrency() {
        return $this->currency;
    }
    
    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    
}