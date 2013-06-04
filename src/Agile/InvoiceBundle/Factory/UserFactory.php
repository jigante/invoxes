<?php 

namespace Agile\InvoiceBundle\Factory;

use Symfony\Component\Security\Core\SecurityContextInterface;

class UserFactory
{
    private $context;

    public function __construct(SecurityContextInterface $context)
    {
        $this->context = $context;
    }

    public function get()
    {
        if (null === $token = $this->context->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            return null;
        }

        return $user;
    }
}