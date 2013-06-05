<?php 

namespace Agile\InvoiceBundle\Security\Authorization\Voter;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ContextVoter implements VoterInterface
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function supportsAttribute($attribute)
    {
        return $attribute === 'CONTEXT';
    }

    public function supportsClass($class)
    {
        return true;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if ($this->supportsClass($object) && $this->container->get('context.company')) {
            foreach ($attributes as $attribute) {
                if ($this->supportsAttribute($attribute)) {
                    if ($company == $object->getCompany()) {
                        return VoterInterface::ACCESS_GRANTED;
                    }
                    return VoterInterface::ACCESS_DENIED;
                }
            }
        }

        return VoterInterface::ACCESS_ABSTAIN;
    }
}