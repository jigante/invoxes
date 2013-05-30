<?php 

namespace Agile\InvoiceBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserSettingRepository extends EntityRepository
{
    /**
     * Set the setting value
     */
    public function setUserSetting($user, $settingName, $settingValue)
    {
        $em = $this->getEntityManager();
        $userSetting = $this->retrieveUserSetting($user, $settingName);

        if (is_null($userSetting)) {
            $userSetting = new UserSetting();
            $userSetting->setUser($user);
            $userSetting->setName($settingName);
        }

        $userSetting->setValue($settingValue);

        $em->persist($userSetting);
        $em->flush();
    }

    /**
     * Is the setting active or inactive?
     */
    public function isActive($user, $settingName)
    {
        $userSetting = $this->retrieveUserSetting($user, $settingName);

        // The evaluation if a setting is active or inactive,
        // also depends if it starts by "disable" or not
        if (stripos($settingName, 'disable') === 0) {
            $disableSetting = true;
        }

        // Set "isActive" false by default
        $isActive = false;

        // If this is a disable setting...
        if ($disableSetting) {
            // ...the setting is active if it is not present in DB or if the value is false
            if (is_null($userSetting) OR !$userSetting->getValue()) {
                $isActive = true;
            }
        } else {
            // else the setting is active if the value is true
            if ($userSetting->getValue()) {
                $isActive = true;
            }
        }

        return $isActive;
    }

    /**
     * Retrieve a user setting given the "user" and the "setting name"
     */
    public function retrieveUserSetting($user, $settingName)
    {
        $em = $this->getEntityManager();
        $query = $em
            ->createQuery('
                SELECT us FROM AgileInvoiceBundle:UserSetting us
                WHERE us.user = :user AND us.name = :name 
            ')
            ->setParameters(array(
                'user' => $user,
                'name' => $settingName,
            ));

        try {
            $userSetting = $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $userSetting = null;
        }

        return $userSetting;
    }

}
