<?php 

namespace Agile\InvoiceBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Agile\InvoiceBundle\Entity\Client;

class LoadClientData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setName('Inter FGCI');
        $client->setAddress("via dei Palmeti, 12\n02100 Milano (MI)");
        $client->setCurrency('EUR');
        // $client->setUser($this->getReference('user-walter-zenga'));
        $client->setCompany($this->getReference('company-walter-zenga'));
        $manager->persist($client);

        $client2 = new Client();
        $client2->setName('Argentina Football Club');
        $client2->setAddress("via dei Campeoni, 44\nBuenos Aires (Argentina)");
        $client2->setCurrency('ARS');
        // $client2->setUser($this->getReference('user-diego-armando-maradona'));
        $client2->setCompany($this->getReference('company-diego-armando-maradona'));
        $manager->persist($client2);

        $manager->flush();

        $this->addReference('client-inter-fgci', $client);
        $this->addReference('client-argentina-football-club', $client2);

    }

    /**
     * {@inheritedDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}