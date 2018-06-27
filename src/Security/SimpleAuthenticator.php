<?php
/**
 * rDig project.
 *
 * @author pietro.baldassarri@gmail.com
 */

namespace App\Security;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Routing\RouterInterface;

class SimpleAuthenticator extends AbstractGuardAuthenticator
{
    const MAX_ATTEMPTS = 3;
    const NO_USERNAME_SUPPLIED = 'No username supplied';
    const NO_PASSWORD_SUPPLIED = 'No password supplied';
    const WRONG_CREDENTIALS = 'Wrong credentials';
    const TOO_MANY_ATTEMPTS = 'Maximum login attempts exceeded. Please contact your administrator';
    const MUST_LOGIN = 'You must login to access this content';

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(RouterInterface $router, UserPasswordEncoderInterface $encoder, ObjectManager $em)
    {
        $this->router = $router;
        $this->encoder = $encoder;
        $this->em = $em;
    }

    public function supports(Request $request)
    {
        return '/login' == $request->getPathInfo() && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        return array(
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (empty($credentials['username'])) {
            throw new BadCredentialsException(self::NO_USERNAME_SUPPLIED);
        }

        try {
            $user = $userProvider->loadUserByUsername($credentials['username']);
            if ($user->getAttempts() > self::MAX_ATTEMPTS) {
                throw new BadCredentialsException(self::TOO_MANY_ATTEMPTS);
            }

            return $user;
        } catch (UsernameNotFoundException $e) {
            throw new BadCredentialsException(self::WRONG_CREDENTIALS);
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if (!empty($credentials['password'])) {
            $plainPassword = $credentials['password'];
        }

        if (!isset($plainPassword)) {
            throw new BadCredentialsException(self::NO_PASSWORD_SUPPLIED);
        }

        if ($this->encoder->isPasswordValid($user, $plainPassword)) {
            return true;
        }

        $user->setAttempts($user->getAttempts() + 1);
        $this->em->persist($user);
        $this->em->flush();
        throw new BadCredentialsException(self::WRONG_CREDENTIALS);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $response = new Response($exception->getMessage(), Response::HTTP_FORBIDDEN);

        return $response;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $user = $token->getUser();
        $user->setAttempts(0);
        $this->em->persist($user);
        $this->em->flush();
        $roles = $token->getUser()->getRoles();
        $sites = $token->getUser()->getSites()->map(function ($item) {
            return $item->getId();
        })->getValues();

        return new JsonResponse([
            'username' => $token->getUsername(),
            'roles' => $roles,
            'allowedSites' => $sites, ]
        );
    }

    public function supportsRememberMe()
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $response = new Response(self::MUST_LOGIN, Response::HTTP_FORBIDDEN);

        return $response;
    }
}
