<?php

namespace Agile\InvoiceBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Bafford\PasswordStrengthBundle\Validator\Constraints as BAssert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_account")
 */
class User extends BaseUser
{

    public function __construct()
    {
        // Always call when extending "FOS\UserBundle\Entity\User" if using the constructor
        parent::__construct();

        $this->clients = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * {@inheritDoc}
     *
     * @Assert\Length(min = 6, groups={"Registration", "Profile", "ResetPassword", "ChangePassword"})
     * @BAssert\PasswordStrength(minLength=0, requireNumbers=true, groups={"Registration", "Profile", "ResetPassword", "ChangePassword"})
     */
    protected $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=100)
     * @Assert\NotBlank(groups={"Registration", "Profile"});
     * @Assert\Length(min=3, max=100, groups={"Registration", "Profile"})
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=100)
     * @Assert\NotBlank(groups={"Registration", "Profile"});
     * @Assert\Length(min=3, max=100, groups={"Registration", "Profile"})
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=100)
     * @Assert\Length(min=5, max=100, groups={"Registration"})
     * @Assert\NotBlank(groups={"Registration"});
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_phone", type="string", length=20)
     * @Assert\NotBlank(groups={"Registration", "Profile"});
     * @Assert\Length(min=3, max=20, groups={"Registration", "Profile"})
     */
    private $contactPhone;

    /**
     * @ORM\Column(name="disabled_welcome", type="boolean")
     */
    private $disabledWelcome = 0;

    /**
     * @ORM\OneToMany(targetEntity="Client", mappedBy="user")
     */
    protected $clients;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Account
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Account
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return Account
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set contactPhone
     *
     * @param string $contactPhone
     * @return Account
     */
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;
    
        return $this;
    }

    /**
     * Get contactPhone
     *
     * @return string 
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }

    public function isDisabledWelcome() {
        return $this->disabledWelcome;
    }
    
    public function setDisabledWelcome($disabledWelcome) {
        $this->disabledWelcome = $disabledWelcome;
    }

    /**
     * Get disabledWelcome
     *
     * @return boolean 
     */
    public function getDisabledWelcome()
    {
        return $this->disabledWelcome;
    }

    /**
     * Add clients
     *
     * @param \Agile\InvoiceBundle\Entity\Client $clients
     * @return User
     */
    public function addClient(\Agile\InvoiceBundle\Entity\Client $clients)
    {
        $this->clients[] = $clients;

        return $this;
    }

    /**
     * Remove clients
     *
     * @param \Agile\InvoiceBundle\Entity\Client $clients
     */
    public function removeClient(\Agile\InvoiceBundle\Entity\Client $clients)
    {
        $this->clients->removeElement($clients);
    }

    /**
     * Get clients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClients()
    {
        return $this->clients;
    }
}
