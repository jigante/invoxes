<?php 

namespace Agile\InvoiceBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function isDisabledWelcome($user)
    {
        $settingName = 'disable_welcome_screen';
        $em = $this->getEntityManager();

        $isDisabledWelcome = $em->getRepository('AgileInvoiceBundle:UserSetting')->isDisabled($user, $settingName);

        return $isDisabledWelcome;
    }
}