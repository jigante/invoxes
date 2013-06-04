<?php 

namespace Agile\InvoiceBundle\Factory;

use Agile\InvoiceBundle\Entity\User;

class CompanyFactory
{
    private $user;

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    public function get()
    {
        $company = null;

        if ($this->user) {
            $company = $this->user->getCompany();
        }

        return $company;
    }
}