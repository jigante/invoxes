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
        $client->setCompany($this->getReference('company-walter-zenga'));
        $manager->persist($client);

        $client2 = new Client();
        $client2->setName('Argentina Football Club');
        $client2->setAddress("via dei Campeoni, 44\nBuenos Aires (Argentina)");
        $client2->setCurrency('ARS');
        $client2->setCompany($this->getReference('company-diego-armando-maradona'));
        $manager->persist($client2);

        $client3 = new Client();
        $client3->setName('Buenos Aires FGCA');
        $client3->setAddress("via dela Victoria, 112\nBuenos Aires (Argentina)");
        $client3->setCurrency('ARS');
        $client3->setCompany($this->getReference('company-diego-armando-maradona'));
        $manager->persist($client3);

        $manager->flush();

        $this->addReference('client-inter-fgci', $client);
        $this->addReference('client-argentina-football-club', $client2);
        $this->addReference('client-buenos-aires-fgca', $client3);

    }

    /**
     * {@inheritedDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}