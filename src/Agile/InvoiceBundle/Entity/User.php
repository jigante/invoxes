<?php

namespace Agile\InvoiceBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Bafford\PasswordStrengthBundle\Validator\Constraints as BAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Entity(repositoryClass="Agile\InvoiceBundle\Entity\UserRepository")
 * @ORM\Table(name="user_account")
 */
class User extends BaseUser
{

    public function __construct()
    {
        // Always call when extending "FOS\UserBundle\Entity\User" if using the constructor
        parent::__construct();

        $this->clients = new ArrayCollection();

        $this->settings = new ArrayCollection();

        $this->invoices = new ArrayCollection();
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
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=100)
     * @Assert\NotBlank(groups={"Registration", "Profile"});
     * @Assert\Length(min=3, max=100, groups={"Registration", "Profile"})
     */
    protected $lastName;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="users")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

    /**
     * @ORM\OneToOne(targetEntity="Company", mappedBy="owner")
     */
    protected $companyOwner;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_phone", type="string", length=20)
     * @Assert\NotBlank(groups={"Registration", "Profile"});
     * @Assert\Length(min=3, max=20, groups={"Registration", "Profile"})
     */
    protected $contactPhone;

    /**
     * @ORM\OneToMany(targetEntity="Client", mappedBy="user")
     */
    protected $clients;

    /**
     * @ORM\OneToMany(targetEntity="UserSetting", mappedBy="user", cascade={"persist"})
     */
    protected $settings;

    /**
     * @ORM\OneToMany(targetEntity="Invoice", mappedBy="user")
     */
    protected $invoices;

    /**
     * @var datetime $created
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var datetime $updated
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updated;

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
     * Set companyOwner
     *
     * @param Company $companyOwner
     * @return User
     */
    public function setCompanyOwner(Company $companyOwner = null)
    {
        $this->companyOwner = $companyOwner;

        return $this;
    }

    /**
     * Get companyOwner
     *
     * @return Company 
     */
    public function getCompanyOwner()
    {
        return $this->companyOwner;
    }

    /**
     * Set company
     *
     * @param Company $company
     * @return User
     */
    public function setCompany(Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return Company 
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

    /**
     * Add client
     *
     * @param Client $client
     * @return User
     */
    public function addClient(Client $client)
    {
        $this->clients[] = $client;

        return $this;
    }

    /**
     * Remove client
     *
     * @param Client $client
     */
    public function removeClient(Client $client)
    {
        $this->clients->removeElement($client);
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

    /**
     * Add setting
     *
     * @param UserSetting $setting
     * @return User
     */
    public function addSetting(UserSetting $setting)
    {

        $setting->setUser($this);

        $this->settings->add($setting);
    }

    /**
     * Remove setting
     *
     * @param UserSetting $settings
     */
    public function removeSetting(UserSetting $setting)
    {
        $this->settings->removeElement($setting);
    }

    /**
     * Get settings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Add invoice
     *
     * @param Invoice $invoice
     * @return User
     */
    public function addInvoice(Invoice $invoice)
    {
        $this->invoices[] = $invoice;

        return $this;
    }

    /**
     * Remove invoice
     *
     * @param Invoice $invoice
     */
    public function removeInvoice(Invoice $invoice)
    {
        $this->invoices->removeElement($invoice);
    }

    /**
     * Get invoices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInvoices()
    {
        return $this->invoices;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }
    
    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set disabled welcome screen
     */
    public function setDisabledWelcome($disabled)
    {
        $disabledWelcome = $this->getDisabledWelcome();
        if(!is_object($disabledWelcome)) {
            $disabledWelcome = new UserSetting();
            $disabledWelcome->setName(UserSetting::DISABLE_WELCOME_SCREEN);
        }

        $disabledWelcome->setValue($disabled);
        $this->addSetting($disabledWelcome);
    
        return $this;
    }

    /**
     * Get disabled welcome screen
     */
    public function getDisabledWelcome()
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('name', UserSetting::DISABLE_WELCOME_SCREEN))
        ;

        $disabledWelcome = $this->getSettings()->matching($criteria)->first();

        return $disabledWelcome;
    }

    /**
     * Check if it's disabled welcome screen for the user
     */
    public function isDisabledWelcome()
    {
        $disabledWelcome = $this->getDisabledWelcome();

        if (!$disabledWelcome OR $disabledWelcome->getValue() == 0) {
            return false;
        } else {
            return true;
        }
    }

}
