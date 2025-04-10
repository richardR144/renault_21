<?php

namespace App\Controller;


use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile; //gère les fichiers uploadés

class MessageControler extends AbstractController
{
    #[Route('/message', name: 'user.message')]
    public function createMessage(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();

        if ($request->isMethod('POST')) {
            $expediteur = $request->request->get('expediteur');
            $destinataire = $request->request->get('destinataire');
            $messageContent = $request->request->get('messageContent');

            $message->setExpediteur($expediteur);
            $message->setDestinataire($destinataire);
            $message->setMessageContent($messageContent);
            $message->setDateEnvoi(new \DateTime());

            $imageFile = $request->files->get('image');

            if ($imageFile instanceof UploadedFile) {
                // Validation de l'image (type, taille, etc.)
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($imageFile->getMimeType(), $allowedMimeTypes)) {
                    $this->addFlash('error', 'Type de fichier non autorisé. Seuls les images JPEG, PNG et GIF sont acceptées.');
                    return $this->render('message/create.html.twig');
                }

                $maxFileSize = 10 * 1024 * 1024; // 10 Mo
                if ($imageFile->getSize() > $maxFileSize) {
                    $this->addFlash('error', 'La taille du fichier est trop importante. La taille maximale autorisée est de 10 Mo.');
                    return $this->render('message/create.html.twig');
                }

                $newFilename = md5(uniqid()) . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move($this->getParameter('images_directory'), $newFilename);
                    $message->setImage($newFilename);

                    $entityManager->persist($message);
                    $entityManager->flush();

                    $this->addFlash('success', 'Message envoyé avec succès.');
                    return $this->redirectToRoute('message_list');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'enregistrement du message. Veuillez réessayer.');
                    // Log de l'erreur pour le débogage
                    error_log($e->getMessage());
                    return $this->render('message/Create.html.twig');
                }
            } else {
                $this->addFlash('error', 'Veuillez sélectionner une image.');
                return $this->render('message/Create.html.twig');
            }
        }

        return $this->render('message/Create.html.twig');
    }


    /*La méthode listMessages utilise maintenant le MessageRepository pour récupérer
    les messages au lieu de l’EntityManager, c'est mieux pour mon code (préocupations séparés, réutilisable et pour les test unitaires*/
    #[Route('/messages', name: 'message_list')]
    public function listMessage(MessageRepository $messageRepository): Response
    {
        $messages = $messageRepository->findAll();
        return $this->render('message/list.html.twig', [
            'messages' => $messages
        ]);
    }
}
