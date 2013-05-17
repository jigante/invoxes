<?php 

namespace Agile\InvoiceBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Agile\InvoiceBundle\Entity\User;

class TestCase extends WebTestCase
{

/**
 * Useful links used to solve the login problem in functional testing with symfony2:
 * - http://stackoverflow.com/questions/8455776/how-to-develop-by-faking-login-to-test-acls-in-symfony-2
 * - http://symfony.com/doc/current/cookbook/testing/simulating_authentication.html
 */

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    protected $client = null;

    public function __construct()
    {
        $this->emptyEntityTable('AgileInvoiceBundle:Contact');

        $this->emptyEntityTable('AgileInvoiceBundle:Client');

        $this->emptyEntityTable('AgileInvoiceBundle:User');
        $this->createLoginUser();
    }

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

        $this->client = static::createClient();
    }

    public function emptyEntityTable($entity)
    {
        $this->setUp();
        $q = $this->em->createQuery('DELETE FROM '.$entity.' e');
        $numDeleted = $q->execute(); 
        $this->tearDown();       
    }

    // public function emptyEntityTable($entity)
    // {
    //     $this->setUp();
    //     $q = $this->em->createQuery('TRUNCATE TABLE '.$entity);
    //     $truncateTable = $q->execute(); 
    //     $this->tearDown();       
    // }

    public function createLoginUser()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $factory = $container->get('security.encoder_factory');
        $user = new User();

        $user->setFirstName('Test User First Name');
        $user->setLastName('Test User Last Name');
        $user->setCompany('Test User Company');
        $user->setEmail('test@user.it');
        $user->setContactPhone('34789786756');
        $user->setUsername('testuser');
        $user->setEnabled(1);

        // Set Password for user
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword('testpassword', $user->getSalt());
        $user->setPassword($password);

        $this->setUp();
        $this->em->persist($user);
        $this->em->flush();
        $this->tearDown(); 
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }

    protected function logIn($username)
    {
        $container = $this->client->getContainer();
        $session = $container->get('session');
        $doctrine = $container->get('doctrine');
        $user = $this->loadUser($doctrine, $username);

        $firewall = 'main';
        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    private function loadUser($doctrine, $username) {
        // Don't have to use doctrine if you don't want to, you could use
        // a service to load your user since you have access to the
        // container.

        // Assumes User entity implements UserInterface
        return $doctrine
                ->getRepository('AgileInvoiceBundle:User')
                ->findOneByUsername($username);
    }

}