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
        if (is_object($class) AND method_exists($class, 'getCompany')) {
            return true;
        } else {
            return false;
        }
        
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if ($company = $this->container->get('context.company')) {
            foreach ($attributes as $attribute) {
                if ($this->supportsAttribute($attribute)) {
                    if ($this->supportsClass($object) AND $company == $object->getCompany()) {
                        return VoterInterface::ACCESS_GRANTED;
                    }
                    return VoterInterface::ACCESS_DENIED;
                }
            }
        }

        return VoterInterface::ACCESS_ABSTAIN;
    }
}