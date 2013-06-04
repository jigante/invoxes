<?php

namespace Agile\InvoiceBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Listener responsible to change the redirection when user registration is successfull
 */

class UserRegistrationSuccessListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS=> 'onRegistrationSuccess',
        );
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        // Set default values for the company
        $user = $event->getForm()->getData();
        $company = $user->getCompany();
        $company->setOwner($user);
        $company->setReceiptRecipients($user->getEmail());
        // $company->setFiscalYearStart(1);
        // $company->setCurrency('EUR');

        // redirect user to home page
        $url = $this->router->generate('home');

        $event->setResponse(new RedirectResponse($url));
    }
}