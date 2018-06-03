<?php

namespace App\Security;

use App\Entity\Main\SiteRelateEntityInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\RoleVoter;

/**
 *
 *
 * @package App\Security
 */
class VocTableCrudVoter extends Voter
{
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    /**
     * Modifying tables requires graduated privileges
     *
     * @param string $attribute An attribute, it should be in the form table|action to be supported e.g. site|create
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (in_array($attribute, ['voc|delete', 'voc|create', 'voc|update'])) {
            return true;
        }

        return false;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        list($table, $action) = explode('|', $attribute);
        $role = $action === 'update' ? ["ROLE_ADMIN"] : ["ROLE_SUPER_USER"];
        if ($this->decisionManager->decide($token, $role)) {
            return true;
        }
        return false;
    }
}