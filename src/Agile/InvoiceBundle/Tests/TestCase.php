<?php 

namespace Agile\InvoiceBundle\Tests;

// ### Without using "LiipFunctionalTestBundle" ###
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// ### Using "LiipFunctionalTestBundle" ###
use Liip\FunctionalTestBundle\Test\WebTestCase;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Agile\InvoiceBundle\Entity\User;

// ### Without using "LiipFunctionalTestBundle" ###
// // use Doctrine\Common\DataFixtures\Loader
// use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
// use Doctrine\Common\DataFixtures\Purger\ORMPurger;
// use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

class TestCase extends WebTestCase
{

/**
 * Useful links used to solve the login problem in functional testing with symfony2:
 * - http://stackoverflow.com/questions/8455776/how-to-develop-by-faking-login-to-test-acls-in-symfony-2
 * - http://symfony.com/doc/current/cookbook/testing/simulating_authentication.html
 * - http://stackoverflow.com/questions/9196035/temporary-doctrine2-fixtures-for-testing-with-phpunit
 * - http://stackoverflow.com/questions/6626318/how-to-set-up-doctrine2-fixtures-when-testing-with-phpunit
 * - http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
 * - https://github.com/doctrine/data-fixtures#readme
 * - 
 */

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    protected $client = null;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $container = static::$kernel->getContainer();
        $this->em = $container
            ->get('doctrine')
            ->getManager()
        ;

        $this->client = static::createClient();

        // ### Without using "LiipFunctionalTestBundle" ###
        // // $loader = new Loader;
        // $loader = new ContainerAwareLoader($container);
        // $loader->loadFromDirectory('src/Agile/InvoiceBundle/Tests/DataFixtures/ORM');
        // $purger = new ORMPurger($this->em);
        // $executor = new ORMExecutor($this->em, $purger);
        // $executor->execute($loader->getFixtures());

        // ### Using "LiipFunctionalTestBundle" ###
        // Add doctrine fixtures classes
        $fixtureClasses = array(
            // classes implementing Doctrine\Common\DataFixtures\FixtureInterface
            'Agile\InvoiceBundle\Tests\DataFixtures\ORM\LoadUserData',
        );

        $this->loadFixtures($fixtureClasses);
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