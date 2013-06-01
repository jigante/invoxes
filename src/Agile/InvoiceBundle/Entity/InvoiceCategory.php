<?php

namespace Agile\InvoiceBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity();
 * @ORM\Table(name="invoice_category")
  * @UniqueEntity(fields = {"name", "user"}, message = "Category has already been used")
 */
class InvoiceCategory
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="InvoiceItem", mappedBy="invoiceCategory")
     */
    protected $invoiceItems;
    
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    public function __construct()
    {
        $this->invoiceItems = new ArrayCollection();
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
     * @return InvoiceCategory
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
     * Add invoiceItem
     *
     * @param \Agile\InvoiceBundle\Entity\InvoiceItem $invoiceItem
     * @return InvoiceCategory
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
        $this->invoiceItems->removeElement($invoiceItem);
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
     * Set user
     *
     * @param \Agile\InvoiceBundle\Entity\User $user
     * @return InvoiceCategory
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
