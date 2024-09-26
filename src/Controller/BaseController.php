<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class BaseController extends AbstractController
{
#[Route('/base', name:'base')]
    public function base (Request $request): Response
    {
        return $this->render('base.html.twig');
    }
}



