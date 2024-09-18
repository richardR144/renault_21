<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class ProfilUserController extends AbstractController
{

    #[Route('/profil', name: 'profil')]
   public function profilUser(){
       return $this->render('security/profilUser.html.twig');
   }
}