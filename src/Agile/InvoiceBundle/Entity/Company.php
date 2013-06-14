<?php 

namespace Agile\InvoiceBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Agile\InvoiceBundle\Utility;

/**
 * @ORM\Entity()
 * @ORM\Table(name="company")
 */
class Company
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(groups={"Registration"});
     * @Assert\Length(min=5, max="100")
     */
    protected $name;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="companyOwner")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @Assert\NotBlank();
     */
    protected $owner;

    /**
     * @ORM\Column(name="subscription_plan", type="string", length=100, nullable=true)
     */
    protected $subscriptionPlan;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="company")
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Client", mappedBy="company")
     */
    protected $clients;

    /**
     * @ORM\Column(name="billing_info", type="string", length=100, nullable=true)
     */
    protected $billingInfo;

    /**
     * @ORM\Column(name="receipt_recipients", type="string")
     */
    protected $receiptRecipients;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $receipts;

    /**
     * @ORM\Column(name="fiscal_year_start", type="smallint")
     * @Assert\Range(min = 1, max = 12)
     */
    protected $fiscalYearStart = 1;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(groups={"Preferences"});
     * @Assert\Choice(callback = "getValidTimezones")
     */
    protected $timezone = 'Europe/London';

    /**
     * @ORM\Column(name="date_format", type="string", length=100, nullable=true)
     * @Assert\NotBlank();
     * @Assert\Choice(callback = "getValidDateFormats")
     */
    protected $dateFormat = '%d/%m/%Y';

    /**
     * @ORM\Column(type="string", length=3)
     */
    protected $currency = 'EUR';

    /**
     * @ORM\Column(name="currency_placement", type="string", length=100, nullable=true)
     */
    protected $currencyPlacement;

    /**
     * @ORM\Column(name="include_currency_code", type="boolean")
     */
    protected $includeCurrencyCode = 0;

    /**
     * @ORM\Column(name="number_format", type="string", length=100, nullable=true)
     */
    protected $numberFormat;

    /**
     * @ORM\Column(name="color_scheme", type="string", length=100, nullable=true)
     */
    protected $colorScheme;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $logo;

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

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->clients = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

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
     * Set name
     *
     * @param string $name
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set subscriptionPlan
     *
     * @param string $subscriptionPlan
     * @return Company
     */
    public function setSubscriptionPlan($subscriptionPlan)
    {
        $this->subscriptionPlan = $subscriptionPlan;

        return $this;
    }

    /**
     * Get subscriptionPlan
     *
     * @return string 
     */
    public function getSubscriptionPlan()
    {
        return $this->subscriptionPlan;
    }

    /**
     * Set billingInfo
     *
     * @param string $billingInfo
     * @return Company
     */
    public function setBillingInfo($billingInfo)
    {
        $this->billingInfo = $billingInfo;

        return $this;
    }

    /**
     * Get billingInfo
     *
     * @return string 
     */
    public function getBillingInfo()
    {
        return $this->billingInfo;
    }

    /**
     * Set receiptRecipients
     *
     * @param string $receiptRecipients
     * @return Company
     */
    public function setReceiptRecipients($receiptRecipients)
    {
        $this->receiptRecipients = $receiptRecipients;

        return $this;
    }

    /**
     * Get receiptRecipients
     *
     * @return string 
     */
    public function getReceiptRecipients()
    {
        return $this->receiptRecipients;
    }

    /**
     * Set receipts
     *
     * @param string $receipts
     * @return Company
     */
    public function setReceipts($receipts)
    {
        $this->receipts = $receipts;

        return $this;
    }

    /**
     * Get receipts
     *
     * @return string 
     */
    public function getReceipts()
    {
        return $this->receipts;
    }

    /**
     * Set fiscalYearStart
     *
     * @param string $fiscalYearStart
     * @return Company
     */
    public function setFiscalYearStart($fiscalYearStart)
    {
        $this->fiscalYearStart = $fiscalYearStart;

        return $this;
    }

    /**
     * Get fiscalYearStart
     *
     * @return string 
     */
    public function getFiscalYearStart()
    {
        return $this->fiscalYearStart;
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     * @return Company
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string 
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set dateFormat
     *
     * @param string $dateFormat
     * @return Company
     */
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;

        return $this;
    }

    /**
     * Get dateFormat
     *
     * @return string 
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Company
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set currencyPlacement
     *
     * @param string $currencyPlacement
     * @return Company
     */
    public function setCurrencyPlacement($currencyPlacement)
    {
        $this->currencyPlacement = $currencyPlacement;

        return $this;
    }

    /**
     * Get currencyPlacement
     *
     * @return string 
     */
    public function getCurrencyPlacement()
    {
        return $this->currencyPlacement;
    }

    /**
     * Set includeCurrencyCode
     *
     * @param boolean $includeCurrencyCode
     * @return Company
     */
    public function setIncludeCurrencyCode($includeCurrencyCode)
    {
        $this->includeCurrencyCode = $includeCurrencyCode;

        return $this;
    }

    /**
     * Get includeCurrencyCode
     *
     * @return boolean 
     */
    public function getIncludeCurrencyCode()
    {
        return $this->includeCurrencyCode;
    }

    /**
     * Set numberFormat
     *
     * @param string $numberFormat
     * @return Company
     */
    public function setNumberFormat($numberFormat)
    {
        $this->numberFormat = $numberFormat;

        return $this;
    }

    /**
     * Get numberFormat
     *
     * @return string 
     */
    public function getNumberFormat()
    {
        return $this->numberFormat;
    }

    /**
     * Set colorScheme
     *
     * @param string $colorScheme
     * @return Company
     */
    public function setColorScheme($colorScheme)
    {
        $this->colorScheme = $colorScheme;

        return $this;
    }

    /**
     * Get colorScheme
     *
     * @return string 
     */
    public function getColorScheme()
    {
        return $this->colorScheme;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Company
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Company
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
     * @return Company
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
     * Set owner
     *
     * @param User $owner
     * @return Company
     */
    public function setOwner(User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Agile\InvoiceBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add user
     *
     * @param User $user
     * @return Company
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add client
     *
     * @param Client $client
     * @return Company
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

    public static function getValidMonths()
    {
        return array_keys(Utility::getMonths());
    }

    public static function getValidTimezones()
    {
        return array_keys(Utility::getTimezones());
    }

    public static function getValidDateFormats()
    {
        return array_keys(Utility::getDateFormats());
    }

}
