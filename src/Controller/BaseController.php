<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class BaseController extends AbstractController
{
    #[Route('/base', name:'base')]
    public function index (): Response
    {
        return $this->render('Page1Accueil.html.twig');
    }

    #[Route('/page1Accueil', name: 'page1Accueil')]
    public function page1Accueil(): Response
    {
        return $this->render('Page1Accueil.html.twig');
    }
}



