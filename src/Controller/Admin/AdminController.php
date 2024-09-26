<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function dashboard(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $admin = $this->getUser();
        $this->addFlash('success', 'Bienvenue sur le tableau de bord admin !');
        // Logique spécifique à l'admin

        $users = $entityManager->getRepository(User::class)->findAll();
        $userCount = $entityManager->getRepository(User::class)->count([]);
        $messageCount = $entityManager->getRepository(Message::class)->count([]);
        return $this->render('dashboard.html.twig', [
            'admin' => $admin,
            'user_count' => $userCount,
            'message_count' => $messageCount,
        ]);
    }
}
