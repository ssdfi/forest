<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\SecurityContextInterface;
class SecurityController extends Controller
{
    /**
     * @Route("/login/", name="login_index")
     * @Method({"GET","POST"})
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        // replace this example code with whatever you need
        dump($request);

        return $this->render('users/login.html.twig', [
                                                // last username entered by the user
                                    'last_username' => $lastUsername,
                                    'error'         => $error,
        ]);
    }
    /**
     * @Route("/login_check/", name="login_check")
     */
    public function loginCheckAction() {
      throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }
    /**
     * @Route("/logout/", name="logout")
     */
    public function logoutAction() {}
}
