<?php

namespace Agile\InvoiceBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Agile\InvoiceBundle\Entity\Company;

/**
 * ClientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClientRepository extends EntityRepository
{
    // public function findContacts($client_id)
    // {
    //     $query = $this->getEntityManager()->createQuery(
    //         'SELECT c FROM AgileInvoiceBundle:Contact c WHERE c.client = :client_id ORDER BY c.firstName ASC'
    //     )->setParameter('client_id', $client_id);

    //     $contacts = $query->getResult();

    //     return $contacts;
    // }

    public function findAllJoinedToContacts(Company $company)
    {
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select(array('cl', 'co'))
            ->from('AgileInvoiceBundle:Client', 'cl')
            ->leftJoin('cl.contacts', 'co')
            ->where('cl.archived = :archived')
            ->andWhere('cl.company = :company')
            ->setParameters(array('archived' => 0, 'company' => $company))
            ->orderBy('cl.name', 'ASC')
            ->addOrderBy('co.firstName', 'ASC')
            ->getQuery()
        ;

        $clients = $query->getResult();

        return $clients;
    }

    public function findInactive($company)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT c FROM AgileInvoiceBundle:Client c WHERE c.company = :company AND c.archived = :archived ORDER BY c.name ASC'
        )->setParameters(array('company' => $company, 'archived' => 1));

        $clients = $query->getResult();

        return $clients;
    }

    public function countInactiveClients($company)
    {
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder()
            ->select('count(c.id)')
            ->from('AgileInvoiceBundle:Client', 'c')
            ->where('c.company = :company')
            ->andWhere('c.archived = :archived')
            ->setParameters(array('company' => $company, 'archived' => 1))
            ->getQuery()
        ;

        $count = $query->getSingleScalarResult();

        return $count;
    }

    
    // public function findAllByCompany(Company $company)
    // {
    //     // $em = $this->getEntityManager();
    //     // $query = $em->createQuery(
    //     //     'SELECT c FROM AgileInvoiceBundle:Client c
    //     //     WHERE c.archived = :archived AND c.company = :company
    //     //     ORDER BY c.name ASC'
    //     // )->setParameters(array('archived' => 0, 'company' => $company,));

    //     $repository = $this->getEntityManager()->getRepository('AgileInvoiceBundle:Client');
    //     $query = $repository->createQueryBuilder('c')
    //         ->where('c.archived = :archived')
    //         ->andWhere('c.company = :company')
    //         // ->setParameter('archived', 0)
    //         ->setParameters(array('archived' => 0, 'company' => $company))
    //         ->orderBy('c.name', 'ASC')
    //         ->getQuery()
    //     ;

    //     $clients = $query->getResult();

    //     return $clients;
    // }

    // public function findActiveClientsQueryBuilder($company)
    // {
    //     $em = $this->getEntityManager();
    //     $queryBuilder = $em->createQueryBuilder()
    //         ->select('c')
    //         ->from('AgileInvoiceBundle:Client', 'c')
    //         ->where('c.company = :company')
    //         ->andWhere('c.archived = :archived')
    //         ->orderBy('c.name', 'ASC')
    //         ->setParameters(array('company' => $company, 'archived' => 0))
    //     ;

    //     return $queryBuilder;
    // }

}
