<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecurityController extends AbstractController
{
  /**
   * @Route("/login", name="login")
   */
   public function login(AuthenticationUtils $authenticationUtils, AuthorizationCheckerInterface $authChecker){

     /*if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
         return new RedirectResponse('/');
     }*/
     if ($authChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
        return new RedirectResponse('/');
    }
     else{

   $error = $authenticationUtils->getLastAuthenticationError();
   $lastUsername = $authenticationUtils->getLastUsername();

   return $this->render('security/index.html.twig', array(
      'last_username' => $lastUsername,
      'error'         => $error,
      'title'         => 'Iniciar Sesión'
   ));
    }
}
}
