<?php 

namespace Agile\InvoiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Agile\InvoiceBundle\Entity\User;

/**
 * User Controller
 * @Route("/users")
 */
class UserController extends Controller
{
    /**
     * @Route("/{id}/disable_welcome_screen", name="disable_welcome_screen")
     */
    public function disableWelcomeScreen($id)
    {
        $user = $this->getUser();
        $settingName = 'disable_welcome_screen';

        $user->setDisabledWelcome(1);
        $this->get('fos_user.user_manager')->updateUser($user);

        return $this->redirect($this->generateUrl('home'));
    }
}

