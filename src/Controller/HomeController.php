<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class HomeController extends AbstractController{
#[Route('/', name:'base')]
    public function index (Request $request): Response
    {
        return $this->render('Page1Accueil.html.twig');
    }
}



