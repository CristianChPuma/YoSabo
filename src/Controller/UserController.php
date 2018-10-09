<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Service\UserManagement;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends AbstractController
{
    /**
     * @Route("/createuser", name="createuser")
     */
    public function createUser(Request $request, UserManagement $usermgm, UserPasswordEncoderInterface $passwordEncoder)
    {

          if($data = $request->request->get('userdata')){
          $entityManager = $this->getDoctrine()->getManager();

          $user = $usermgm->createUser($data, $passwordEncoder);
          $entityManager->persist($user);
          $entityManager->flush();

          $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
          $this->container->get('security.token_storage')->setToken($token);
          $this->container->get('session')->set('_security_main', serialize($token));

            return new JsonResponse(array(

             ));

           }

    }

    public function getNormalUser(){

    }

}
