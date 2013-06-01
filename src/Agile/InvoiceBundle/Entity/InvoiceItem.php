<?php 

namespace Agile\InvoiceBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="invoice_item")
 */
class InvoiceItem
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="invoiceItems")
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     */
    protected $invoice;

    /**
     * @ORM\ManyToOne(targetEntity="InvoiceCategory", inversedBy="invoiceItems")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $invoiceCategory;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=9, scale=2)
     */
    private $unitPrice;

    /**
     * @ORM\Column(type="boolean")
     */
    private $applyTax;

    /**
     * @ORM\Column(type="boolean")
     */
    private $applyTax2;

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
     * Set description
     *
     * @param string $description
     * @return InvoiceItem
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set quantity
     *
     * @param float $quantity
     * @return InvoiceItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set unitPrice
     *
     * @param float $unitPrice
     * @return InvoiceItem
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return float 
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set applyTax
     *
     * @param boolean $applyTax
     * @return InvoiceItem
     */
    public function setApplyTax($applyTax)
    {
        $this->applyTax = $applyTax;

        return $this;
    }

    /**
     * Get applyTax
     *
     * @return boolean 
     */
    public function getApplyTax()
    {
        return $this->applyTax;
    }

    /**
     * Set applyTax2
     *
     * @param boolean $applyTax2
     * @return InvoiceItem
     */
    public function setApplyTax2($applyTax2)
    {
        $this->applyTax2 = $applyTax2;

        return $this;
    }

    /**
     * Get applyTax2
     *
     * @return boolean 
     */
    public function getApplyTax2()
    {
        return $this->applyTax2;
    }

    /**
     * Set invoice
     *
     * @param \Agile\InvoiceBundle\Entity\Invoice $invoice
     * @return InvoiceItem
     */
    public function setInvoice(\Agile\InvoiceBundle\Entity\Invoice $invoice = null)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return \Agile\InvoiceBundle\Entity\Invoice 
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Set invoiceCategory
     *
     * @param \Agile\InvoiceBundle\Entity\InvoiceCategory $invoiceCategory
     * @return InvoiceItem
     */
    public function setInvoiceCategory(\Agile\InvoiceBundle\Entity\InvoiceCategory $invoiceCategory = null)
    {
        $this->invoiceCategory = $invoiceCategory;

        return $this;
    }

    /**
     * Get invoiceCategory
     *
     * @return \Agile\InvoiceBundle\Entity\InvoiceCategory 
     */
    public function getInvoiceCategory()
    {
        return $this->invoiceCategory;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return InvoiceItem
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
     * @return InvoiceItem
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
