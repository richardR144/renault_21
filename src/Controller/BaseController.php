<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class BaseController extends AbstractController
{
    #[Route('/base', name: 'base')]
    public function index(): Response
    {
        return $this->render('Accueil.html.twig');
    }

    #[Route('/Accueil', name: 'Accueil')]
    public function Accueil(): Response
    {
        return $this->render('Accueil.html.twig');
    }
    #[Route('/Inscription', name: 'Inscription')]
    public function Inscription(): Response
    {
        return $this->render('Inscription.html.twig');
    }



    #[Route('/Depot', name: 'Depot')]
    public function Depot(): Response
    {
        return $this->render('Depot.html.twig');
    }
    #[Route('/ListPiece', name: 'ListPiece')]
    public function ListPiece(): Response
    {
        $users = [
            ['name' => 'Nom Prénom 1', 'message' => 'Message 1', 'image' => 'image1.jpg'],
            ['name' => 'Nom Prénom 2', 'message' => 'Message 2', 'image' => 'image2.jpg'],
            ['name' => 'Nom Prénom 3', 'message' => 'Message 3', 'image' => 'image3.jpg'],
        ];

        return $this->render('ListPiece.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/Regle', name: 'Regle')]
    public function Regle(): Response
    {
        return $this->render('Regle.html.twig');
    }

    #[Route('/Popup', name: 'Popup')]
    public function Popup(): Response
    {
        return $this->render('Popup.html.twig');
    }
}



