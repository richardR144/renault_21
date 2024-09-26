<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileUserController extends AbstractController
{
    #[Route('/profileUser', name: 'profileUser')]
    public function profileUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $this->getUser();
        $this->addFlash('success', 'Bienvenue sur votre profil !');

        return $this->render('profileUser.html.twig', [
            'user' => $user,
        ]);
    }
}