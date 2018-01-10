<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Method("POST")
     */
    public function login(Request $request)
    {
    }

    /**
     * @Route("/logout", name="logout")
     * @Method("POST")
     */
    public function logout(Request $request)
    {
    }

    /**
     * @Route("/logoutSuccess", name="logoutSuccess")
     */
    public function logoutSuccess(Request $request)
    {
        //@TODO check request
        return new Response("User logged out");
    }
}
