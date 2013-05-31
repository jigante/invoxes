<?php 

namespace Agile\InvoiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * User Controller
 * @Route("/users")
 */
class UserController extends Controller
{
    /**
     * @Route("/disable_welcome_screen", name="disable_welcome_screen")
     */
    public function disableWelcomeScreen()
    {
        $user = $this->getUser();

        $user->setDisabledWelcome(1);
        $this->get('fos_user.user_manager')->updateUser($user);

        return $this->redirect($this->generateUrl('home'));
    }
}

