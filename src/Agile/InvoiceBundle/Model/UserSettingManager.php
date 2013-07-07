<?php 

namespace Agile\InvoiceBundle\Model;

use Doctrine\ORM\EntityManager;
use Agile\InvoiceBundle\Entity\User;

class UserSettingManager extends BaseModelManager
{

    protected $user;

    /**
     * Constructor.
     *
     * @param EntityManager  $em
     * @param string   $class
     * @param User $user
     */
    public function __construct(EntityManager $em, $class, User $user) {
        parent::__construct($em, $class);
        $this->user = $user;
    }

    public function isActive($settingName)
    {
        return $this->repository->isActive($this->user, $settingName);
    }

    public function isDisabled($settingName)
    {
        return $this->repository->isDisabled($this->user, $settingName);
    }

    public function set($settingName, $settingValue)
    {
        return $this->repository->set($this->user, $settingName, $settingValue);
    }

}