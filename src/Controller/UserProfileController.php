<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserProfileController extends AbstractController
{
    /**
     * @Route("/perfil", name="user_profile")
     */
    public function index(Security $security)
    {

        $user = $security->getUser();
        $username = ucwords($user->getUsername());

        return $this->render('frontend/user_profile/index.html.twig', [
            'title' => $username . ' - Perfil',
        ]);
    }

    public function fillUsers(){

      $users = $this->getDoctrine()
          ->getRepository(User::class)
          ->findLatests(20);

          $limit = 10;

          $pag = $this->getDoctrine()
          ->getRepository(User::class)
          ->findbyPage(1, $limit);

          $usersresult = $pag['paginator'];
          $usersall = $pag['query'];

          $maxPages = ceil($pag['paginator']->count() / $limit);

          return $this->render(
                'frontend/components/usercard.html.twig',array('users' => $users)
            );

    }

}
