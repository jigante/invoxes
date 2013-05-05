<?php

namespace Agile\InvoiceBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="user_account")
 */
class User extends BaseUser
{
    // public function __construct()
    // {
    //     parent::__construct();
    //     // your own logic
    // }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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

}