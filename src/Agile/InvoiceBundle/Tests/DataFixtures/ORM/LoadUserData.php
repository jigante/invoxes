<?php 

namespace Agile\InvoiceBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Agile\InvoiceBundle\Entity\User;
use Agile\InvoiceBundle\Entity\Company;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $factory = $this->container->get('security.encoder_factory');

        $user = new User();
        $user->setFirstName('Walter');
        $user->setLastName('Zenga');
        $user->setEmail('walter@zenga.it');
        $user->setContactPhone('34789786756');
        $user->setUsername('walter.zenga');
        $user->setEnabled(1);

        $company = new Company();
        $company->setName('Walter Zenga LTD');
        $user->setCompany($company);
        $company->setOwner($user);
        $company->setReceiptRecipients($user->getEmail());

        // Set Password for user
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword('walter.zenga', $user->getSalt());
        $user->setPassword($password);
        $manager->persist($user);
        $manager->persist($company);

        // User 2
        $user2 = new User();
        $user2->setFirstName('Diego Armando');
        $user2->setLastName('Maradona');
        $user2->setEmail('diego.armando@maradona.it');
        $user2->setContactPhone('34753892153836');
        $user2->setUsername('diego.armando.maradona');
        $user2->setEnabled(1);

        $company2 = new Company();
        $company2->setName('Diego Armando Maradona LTD');
        $user2->setCompany($company2);
        $company2->setOwner($user2);
        $company2->setReceiptRecipients($user2->getEmail());

        // Set Password for user2
        $encoder2 = $factory->getEncoder($user2);
        $password2 = $encoder2->encodePassword('diego.armando.maradona', $user2->getSalt());
        $user2->setPassword($password2);
        $manager->persist($user2);
        $manager->persist($company2);

        // User 3
        $user3 = new User();
        $user3->setFirstName('Michel');
        $user3->setLastName('Platini');
        $user3->setEmail('michel@platini.it');
        $user3->setContactPhone('332456723456');
        $user3->setUsername('michel.platini');
        $user3->setEnabled(1);

        $company3 = new Company();
        $company3->setName('Michel Platini LTD');
        $user3->setCompany($company3);
        $company3->setOwner($user3);
        $company3->setReceiptRecipients($user3->getEmail());

        // Set Password for user3
        $encoder3 = $factory->getEncoder($user3);
        $password3 = $encoder3->encodePassword('michel.platini', $user3->getSalt());
        $user3->setPassword($password3);
        $manager->persist($user3);
        $manager->persist($company3);

        $manager->flush();

        // store reference to Users for assigning clients
        // $this->addReference('user-walter-zenga', $user);
        // $this->addReference('user-diego-armando-maradona', $user2);

        $this->addReference('company-walter-zenga', $company);
        $this->addReference('company-diego-armando-maradona', $company2);
        $this->addReference('company-michel-platini', $company3);
    }

    /**
     * {@inheritedDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}