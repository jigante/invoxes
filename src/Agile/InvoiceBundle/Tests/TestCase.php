<?php 

namespace Agile\InvoiceBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class TestCase extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }

    public function emptyEntityTable($entity)
    {
        $this->setUp();
        $q = $this->em->createQuery('DELETE FROM '.$entity.' e');
        $numDeleted = $q->execute(); 
        $this->tearDown();       
    }

    // public function testSearchByCategoryName()
    // {
    //     $products = $this->em
    //         ->getRepository('AcmeStoreBundle:Product')
    //         ->searchByCategoryName('foo')
    //     ;

    //     $this->assertCount(1, $products);
    // }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }

}