<?php

namespace App\Controller;


use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile; //gère les fichiers uploadés
use \DateTime;   //importation de DateTime depuis l'espace de noms global
class MessageControler extends AbstractController
{
    #[Route('/message', name:'user.message')]
   public function createMessage(Request $request, EntityManagerInterface $entityManager):Response
    {
        if ($request->getMethod() == "POST") {
            $expediteur = $request->request->get('expediteur');
            $destinataire = $request->request->get('destinataire');
            $messageContent = $request->request->get('messageContent');

            $message = new Message();

            $message->setExpediteur($expediteur);
            $message->setDestinataire($destinataire);
            $message->setMessageContent($messageContent);
            $message->setDateEnvoi(new \DateTime());

            /* Ajout de la gestion de l'image
             * @var UploadedFile $image */
            $image = $request->files->get('image');

            /*si l'image est présente alors on associe la récup. de l'image, la génération
            d'un nom uniq, le déplacement de l'image et son association avec le message*/

            if ($image) {
                $imageName = md5(uniqid()) . '.' . $image->guessExtension();

                /*uniqid(): Cette fonction génère un identifiant unique,
                  md5(): Cette fonction applique l’algorithme de hachage, ça produit une chaîne de 32 caractères et
                  $image->guessExtension(): Cette méthode devine l’extension du fichier image (jpg, png, etc...) */

                $image->move($this->getParameter('images_directory'), $imageName);

                /*$message->setImage($imageName) : Cette méthode associe le nom de l’image, qui est stocké dans le répertoire entity/Message
                 ça permet de sauvegarder le nom de l'image dans la base de données et cela garantit aussi la sécurité et son accessibilité*/

                $message->setImage($imageName);

                /*cette méthode (but) indique à Doctrine que l'objet $message doit être sauvegarder dans la BDD et quelle est géréé par l'EntityManager*/
                $entityManager->persist($message);
                $entityManager->flush();    /*flush éxécute les requêtes SQL et les synchronise avec la BDD et son but est le même*/

                return $this->redirectToRoute('message_list');
            }
            return $this->render('message/create.html.twig');
        }
        return $this->render('message/create.html.twig');
    }


    /*La méthode listMessages utilise maintenant le MessageRepository pour récupérer
    les messages au lieu de l’EntityManager, c'est mieux pour mon code (préocupations séparés, réutilisable et pour les test unitaires*/
    #[Route('/messages', name: 'message_list')]
    public function listMessages(MessageRepository $messageRepository): Response
    {
        $messages = $messageRepository->findAll();
        return $this->render('message/list.html.twig', [
            'messages' => $messages
        ]);
    }
}
