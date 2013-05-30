<?php 

namespace Agile\InvoiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * User Controller
 * @Route("/users/settings")
 */
class UserSettingController extends Controller
{

    /**
    * @Route("/xhr/{user}/{settingName}/{settingValue}", name="set_ajax_user_setting", options={"expose"=true})
    */
    public function setAjaxUserSetting($settingName, $settingValue)
    {
        $user = $this->getUser();
        $request = $this->getRequest();

        // Is it an Ajax request?
        if ($request->isXmlHttpRequest()) {
            // Set the user setting
            $em = $this->getDoctrine()->getManager();
            $setting = $em->getRepository('AgileInvoiceBundle:UserSetting')->setUserSetting(
                $user, $settingName, $settingValue
            );

            return Response::create('Ok');
        } else {
            throw $this->createNotFoundException();
        }
        
    }

}