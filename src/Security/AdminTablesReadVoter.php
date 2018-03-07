<?php

namespace App\Security;

use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class AdminTablesReadVoter requires ROLE_ADMIN privileges
 * @package App\Security
 */
class AdminTablesReadVoter extends Voter
{
    private $decisionManager;

    private $tables = [
        'user',
        'user-allowed-sites'
    ];

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    /**
     * Read admin tables requires ROLE_ADMIN privileges
     *
     * @param string $attribute An attribute, it should be in the form table|action to be supported e.g. site|create
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        @list($table, $action) = explode('|', $attribute);
        return isset($action)
            && $action === 'read'
            && in_array($table, $this->tables);
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }
        return false;
    }
}