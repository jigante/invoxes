<?php 

namespace Agile\InvoiceBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Agile\InvoiceBundle\Entity\InvoiceRepository")
 * @ORM\Table(name="invoice")
 * @UniqueEntity(fields = {"number", "user"}, message = "Number has already been used")
 */
class Invoice
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invoiceItems = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="invoices")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="invoices")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    protected $client;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(name="po_number", type="string", length=50, nullable=true)
     */
    private $poNumber;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     */
    private $tax;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     */
    private $tax2;

    /**
     * @ORM\Column(name="issue_date", type="date")
     */
    private $issueDate;

    /**
     * @ORM\Column(name="due_date", type="date")
     */
    private $dueDate;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $discount;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $currency;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $summary;

    /**
     * @ORM\OneToMany(targetEntity="InvoiceItem", mappedBy="invoice")
     */
    protected $invoiceItems;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @var datetime $created
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;


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
     * Set number
     *
     * @param string $number
     * @return Invoice
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set poNumber
     *
     * @param string $poNumber
     * @return Invoice
     */
    public function setPoNumber($poNumber)
    {
        $this->poNumber = $poNumber;

        return $this;
    }

    /**
     * Get poNumber
     *
     * @return string 
     */
    public function getPoNumber()
    {
        return $this->poNumber;
    }

    /**
     * Set tax
     *
     * @param integer $tax
     * @return Invoice
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax
     *
     * @return integer 
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set tax2
     *
     * @param integer $tax2
     * @return Invoice
     */
    public function setTax2($tax2)
    {
        $this->tax2 = $tax2;

        return $this;
    }

    /**
     * Get tax2
     *
     * @return integer 
     */
    public function getTax2()
    {
        return $this->tax2;
    }

    /**
     * Set issueDate
     *
     * @param \DateTime $issueDate
     * @return Invoice
     */
    public function setIssueDate($issueDate)
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    /**
     * Get issueDate
     *
     * @return \DateTime 
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * Set dueDate
     *
     * @param \DateTime $dueDate
     * @return Invoice
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime 
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set discount
     *
     * @param integer $discount
     * @return Invoice
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return integer 
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Invoice
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
     * Set summary
     *
     * @param string $summary
     * @return Invoice
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Invoice
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set user
     *
     * @param \Agile\InvoiceBundle\Entity\User $user
     * @return Invoice
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

    /**
     * Set client
     *
     * @param \Agile\InvoiceBundle\Entity\Client $client
     * @return Invoice
     */
    public function setClient(\Agile\InvoiceBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Agile\InvoiceBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Add invoiceItem
     *
     * @param \Agile\InvoiceBundle\Entity\InvoiceItem $invoiceItem
     * @return Invoice
     */
    public function addInvoiceItem(\Agile\InvoiceBundle\Entity\InvoiceItem $invoiceItem)
    {
        $this->invoiceItems[] = $invoiceItem;

        return $this;
    }

    /**
     * Remove invoiceItem
     *
     * @param \Agile\InvoiceBundle\Entity\InvoiceItem $invoiceItem
     */
    public function removeInvoiceItem(\Agile\InvoiceBundle\Entity\InvoiceItem $invoiceItem)
    {
        $this->invoiceItem->removeElement($invoiceItem);
    }

    /**
     * Get invoiceItems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInvoiceItems()
    {
        return $this->invoiceItems;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Invoice
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Invoice
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
}
