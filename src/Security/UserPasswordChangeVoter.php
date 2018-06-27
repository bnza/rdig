<?php

namespace App\Security;

use App\Entity\Main\User;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class AdminVoter requires ROLE_ADMIN privileges
 *
 * @package App\Security
 */
class UserPasswordChangeVoter extends Voter
{
    /**
     * The requested roles privileges
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Modifying tables requires graduated privileges
     *
     * @param string $attribute An attribute, it should be in the form table|action to be supported e.g. site|create
     * @param array $subject  array [ User $user, UserPasswordEncoderInterface $encoder, string $password ]
     *
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if ($attribute === 'user|change-password') {
            if (is_array($subject) && count($subject) > 1)
                return $subject[0] instanceof User && $subject[1] instanceof UserPasswordEncoderInterface;
        }

        return false;
    }

    /**
     * ROLE_ADMIN users and the user CAN change (his own) password
     *
     * @param string $attribute
     * @param array $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if ($token->isAuthenticated()) {
            if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                return true;
            } else if (array_key_exists(2, $subject) && $subject[2]) {
                $isOldPasswordValid = $subject[1]->isPasswordValid($subject[0], $subject[2]);
                $isCurrentUser = $subject[0]->getUsername() === $token->getUsername();
                return $isCurrentUser && $isOldPasswordValid;
            }
        }
        return false;
    }
}