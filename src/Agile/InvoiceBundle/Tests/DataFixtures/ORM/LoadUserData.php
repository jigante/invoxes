<?php 

namespace Agile\InvoiceBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Agile\InvoiceBundle\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setFirstName('Test User Firstname');
        $user->setLastName('Test User Lastname');
        $user->setCompany('Test User Company');
        $user->setEmail('test@user.it');
        $user->setContactPhone('34789786756');
        $user->setUsername('testuser');
        $user->setEnabled(1);

        // Set Password for user
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword('testpassword', $user->getSalt());
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}