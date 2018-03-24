<?php
/**
 * rDig project.
 *
 * @author pietro.baldassarri@gmail.com
 */

namespace App\Security;

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
    const NO_USERNAME_SUPPLIED = 'No username supplied';
    const NO_PASSWORD_SUPPLIED = 'No password supplied';
    const WRONG_CREDENTIALS = 'Wrong credentials';
    const MUST_LOGIN = 'You must login to access this content';

    private $encoder;

    private $router;

    public function __construct(RouterInterface $router, UserPasswordEncoderInterface $encoder)
    {
        $this->router = $router;
        $this->encoder = $encoder;
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
            return $userProvider->loadUserByUsername($credentials['username']);
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

        throw new BadCredentialsException(self::WRONG_CREDENTIALS);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $response = new Response($exception->getMessage(), Response::HTTP_FORBIDDEN);

        return $response;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
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
