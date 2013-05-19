<?php 

namespace Agile\InvoiceBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Agile\InvoiceBundle\Entity\Contact;

class LoadContactData extends AbstractFixture  implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $contact = new Contact();
        $contact->setFirstName('Evaristo');
        $contact->setLastName('Beccalossi');
        $contact->setTitle('Difensore');
        $contact->setEmail('evaristo@beccalossi.it');
        $contact->setPhoneOffice('0234455667');
        $contact->setMobile('34734455667');
        $contact->setFax('0234455667');
        $contact->setClient($this->getReference('client-inter-fgci'));
        $manager->persist($contact);

        $contact2 = new Contact();
        $contact2->setFirstName('Lionel');
        $contact2->setLastName('Messi');
        $contact2->setTitle('Attaccante');
        $contact2->setEmail('lionel@messi.ag');
        $contact2->setPhoneOffice('0298765432');
        $contact2->setMobile('34789674523');
        $contact2->setFax('0212345678');
        $contact2->setClient($this->getReference('client-argentina-football-club'));
        $manager->persist($contact2);
        
        $manager->flush();
    }

    /**
     * {@inheritedDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}