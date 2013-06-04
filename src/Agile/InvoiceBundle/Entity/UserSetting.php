<?php 

namespace Agile\InvoiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
// use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Agile\InvoiceBundle\Entity\UserSettingRepository")
 * @ORM\Table(name="user_setting")
 */
class UserSetting
{

    /**
     * The DISABLE_WELCOME_SCREEN user setting
     *
     * This setting indicates if the welcome screen for the user has to be disabled
     */
    const DISABLE_WELCOME_SCREEN = 'disable_welcome_screen';

    /**
     * The DISABLE_INVOICE_PAGE_TIPS user setting
     *
     * This setting indicates if the tips for the invoice page have to be shown
     */
    const DISABLE_INVOICE_PAGE_TIPS = 'disable_invoice_page_tips';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="settings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;

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
     * @return UserSetting
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
     * Set value
     *
     * @param string $value
     * @return UserSetting
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set user
     *
     * @param \Agile\InvoiceBundle\Entity\User $user
     * @return UserSetting
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
