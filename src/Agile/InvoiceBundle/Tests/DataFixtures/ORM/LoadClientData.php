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
        // Clients for Walter Zenga
        $client = new Client();
        $client->setName('Inter FGCI');
        $client->setAddress("via dei Palmeti, 12\n02100 Milano (MI)");
        $client->setCurrency('EUR');
        $client->setCompany($this->getReference('company-walter-zenga'));
        $manager->persist($client);
        $this->addReference('client-inter-fgci', $client);

        $client = new Client();
        $client->setName('Catania FGCI');
        $client->setAddress("via dei Colonnati, 11\n09111 Catania (CT)");
        $client->setCurrency('EUR');
        $client->setCompany($this->getReference('company-walter-zenga'));
        $manager->persist($client);
        $this->addReference('client-catania-fgci', $client);

        $client = new Client();
        $client->setName('Palermo FGCI');
        $client->setAddress("via degli Stretti, 192\n06100 Palermo (PA)");
        $client->setCurrency('EUR');
        $client->setCompany($this->getReference('company-walter-zenga'));
        $client->setArchived(1);
        $manager->persist($client);
        $this->addReference('client-palermo-fgci', $client);

        // Clients for Diego Armando Maradona
        $client = new Client();
        $client->setName('Argentina Football Club');
        $client->setAddress("via dei Campeoni, 44\nBuenos Aires (Argentina)");
        $client->setCurrency('ARS');
        $client->setCompany($this->getReference('company-diego-armando-maradona'));
        $manager->persist($client);
        $this->addReference('client-argentina-football-club', $client);

        $client = new Client();
        $client->setName('Buenos Aires FGCA');
        $client->setAddress("via dela Victoria, 112\nBuenos Aires (Argentina)");
        $client->setCurrency('ARS');
        $client->setCompany($this->getReference('company-diego-armando-maradona'));
        $manager->persist($client);
        $this->addReference('client-buenos-aires-fgca', $client);

        $manager->flush();        

    }

    /**
     * {@inheritedDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}