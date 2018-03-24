<?php

namespace App\Security;

use App\Entity\SiteRelateEntityInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\RoleVoter;

/**
 *
 *
 * @package App\Security
 */
class TableCrudModifyVoter extends Voter
{
    private $decisionManager;

    private $tables = [
        'user' => ['ROLE_ADMIN'],
        'site' => ['ROLE_ADMIN'],
        'area' => ['ROLE_ADMIN'],
        'bucket' => ['ROLE_USER'],
        'campaign' => ['ROLE_ADMIN'],
        'context' => ['ROLE_USER'],
        'user-allowed-sites' => ['ROLE_ADMIN']
    ];

    private $actions = [
        'create',
        'update',
        'delete'
    ];

    /**
     * The requested roles privileges
     * @var array
     */
    private $roles;

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
        @list($table, $action) = explode('|', $attribute);
        if (isset($table) && array_key_exists($table, $this->tables)) {
            $this->roles = $this->tables[$table];
            if (isset($action) && in_array($action, $this->actions)) {
                return true;
            }
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
        if ($this->decisionManager->decide($token, $this->roles)) {
            if ($this->decisionManager->decide($token, ["ROLE_ADMIN"])) {
                return true;
            } else {
                if ($subject && $subject instanceof SiteRelateEntityInterface) {
                    return $token->getUser()->isSiteAllowed($subject);
                }
                return true;
            }
        }
        return false;
    }
}