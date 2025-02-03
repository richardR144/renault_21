<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Form\PieceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PieceController extends AbstractController
{
    // constructeur

    #[Route('/ajouter-piece', name: 'piece_ajouter')]
    public function upload(Request $request): Response
    {
        $piece = new Piece();
        $piece->setCreatedAt(new \DateTimeImmutable()); // Définir la date de création

        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'), // Dossier où stocker les images
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... gérer les exceptions si le téléchargement échoue
                }

                $piece->setImage($newFilename); // Enregistrez le nom du fichier dans l'entité
            }

            $this->entityManager->persist($piece);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('page5_piece_list');
    }



    #[Route('/modifier-piece/{id}', name: 'piece.modifier', methods: ['GET', 'POST'])]
    public function modifier($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $piece = $entityManager->getRepository(Piece::class)->find($id);

        if (!$piece) {
            throw $this->createNotFoundException('Pièce non trouvée.');
        }

        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('piece.liste');
        }

        return $this->render('modifier_piece.html.twig', [
            'form' => $form->createView(),
            'piece' => $piece,
        ]);
    }


    #[Route('/supprimer-piece/{id}', name: 'piece.supprimer', methods: ['POST'])]
    public function supprimerPiece(Request $request, int $id, EntityManagerInterface $entityManager): Response
    {
        $piece = $entityManager->getRepository(Piece::class)->find($id);

        if (!$piece) {
            throw $this->createNotFoundException('Pièce non trouvée.');
        }

        if ($this->isCsrfTokenValid('delete' . $piece->getId(), $request->request->get('_csrf_token'))) {
            $entityManager->remove($piece);
            $entityManager->flush();
            return $this->redirectToRoute('piece.liste');
        } else {
            // Gestion de l'erreur si le token CSRF est invalide
            $this->addFlash('error', 'Token CSRF invalide.');
        }
        return $this->redirectToRoute('piece.liste'); // Redirige vers la liste ou une autre page
    }
}








