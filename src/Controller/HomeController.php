<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function showHome()
    {
        return $this->render('frontend/login/index.html.twig', [
            'title' => 'Iniciar Sesión',
        ]);
    }



}
