<?php 

namespace Agile\InvoiceBundle\Factory;

use Agile\InvoiceBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Persistence\ObjectManager;

class CompanyFactory
{
    private $user;
    private $session;
    private $entity_manager;

    public function __construct(User $user = null, Session $session, ObjectManager $entityManager)
    {
        $this->user = $user;
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function get()
    {
        $company = null;

        if ($companyId = $this->session->get('context.company_id')) {
            $company = $this->entity_manager
                ->getRepository('AgileInvoiceBundle:Company')
                ->find($companyId);
        }

        if (!$company && $this->user) {
            $company = $this->user->getCompany();
        }

        return $company;
    }
}