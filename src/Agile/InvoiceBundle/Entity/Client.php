<?php 

namespace Agile\InvoiceBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Agile\InvoiceBundle\Entity\ClientRepository")
 * @ORM\Table(name="client")
 */
class Client
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="clients")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank();
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=3)
     */
    protected $currency;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $archived = 0;

    /**
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="client")
     */
    protected $contacts;

    public function _construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }

    public function getAddress() {
        return $this->address;
    }
    
    public function setAddress($address) {
        $this->address = $address;
    }

    public function getCurrency() {
        return $this->currency;
    }
    
    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function isArchived() {
        return $this->archived;
    }
    
    public function setArchived($archived) {
        $this->archived = $archived;
    }
    
    /**
     * Get archived
     *
     * @return boolean 
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * Add contacts
     *
     * @param \Agile\InvoiceBundle\Entity\Contact $contacts
     * @return Client
     */
    public function addContact(\Agile\InvoiceBundle\Entity\Contact $contacts)
    {
        $this->contacts[] = $contacts;
    
        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \Agile\InvoiceBundle\Entity\Contact $contacts
     */
    public function removeContact(\Agile\InvoiceBundle\Entity\Contact $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Set user
     *
     * @param \Agile\InvoiceBundle\Entity\User $user
     * @return Client
     */
    public function setUser(\Agile\InvoiceBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Agile\InvoiceBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
