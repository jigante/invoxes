<?php 

namespace Agile\InvoiceBundle\Model;

use Agile\InvoiceBundle\Model\BaseModelManager;
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

        exit($this->user->getUsername());
    }
}