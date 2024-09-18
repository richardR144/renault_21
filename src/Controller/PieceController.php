<?php

namespace App\Controller;


use App\Entity\Piece;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\PieceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class PieceController extends AbstractController
{
    #[Route('/ajouter-piece', name:'piece.ajouter')]
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
}

