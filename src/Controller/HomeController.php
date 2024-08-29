<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Form\PieceType;
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

    #[Route('/page1', name:'Page1Accueil')]
    public function page1 (Request $request): Response
    {
        return $this->render('Page1Accueil.html.twig');
    }

    #[Route('/page2', name:'Page2Inscription')]
    public function HomeController (Request $request): Response
    {
        return $this->render('Page2Inscription.html.twig');
    }

    #[Route('/page3', name:'Page3Connexion')]
    public function HomeController1 (Request $request): Response
    {
        return $this->render('Page3Connexion.html.twig');
    }

    #[Route('/page4', name:'Page4Depot')]
    public function upload(Request $request): Response
    {
        $piece = new Piece();

        $form = $this->createForm(PieceType::class, $piece);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render('Page4Depot.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/page5', name:'Page5List')]
    public function HomeController3 (Request $request): Response
    {
        return $this->render('Page5List.html.twig');
    }
    #[Route('/page6', name:'Page6PieceRef')]
    public function HomeController4 (Request $request): Response
    {
        return $this->render('Page6PieceRef.html.twig');
    }

    #[Route('/page7', name:'Page7Regle')]
    public function HomeController5 (Request $request): Response
    {
        return $this->render('Page7Regle.html.twig');
    }
    #[Route('/page8', name:'Page8Popup')]
    public function HomeController6 (Request $request): Response
    {
        return $this->render('Page8Popup.html.twig');
    }
    #[Route('/page9', name:'Page9ContenuIna')]
    public function HomeController7 (Request $request): Response
    {
        return $this->render('Page9ContenuIna.html.twig');
    }
    #[Route('/page10', name:'Page10Moderateur')]
    public function HomeController8 (Request $request): Response
    {
        return $this->render('Page10Moderateur.html.twig');
    }

    #[Route('/page11', name:'Page11Message')]
    public function HomeController9 (Request $request): Response
    {
        return $this->render('Page11Message.html.twig');
    }
}



