<?php

namespace App\Controller;

use App\Entity\Piece;
use App\Form\PieceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



/** je suis en mesure d'afficher des images dans votre application Symfony,
 * que ce soit à partir de chemins d'images enregistrés dans la base de données
 * ou via un système de téléchargement d'images
 */
/**uploader les images**/
class PieceAutoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('description', TextType::class)
            ->add('prix', TextType::class)
            ->add('quantite', TextType::class)
            ->add('chemin_image', FileType::class, [
                'label' => 'Image (JPEG, PNG, ...)',
                'mapped' => false, // On ne mappe pas ce champ à l'entité
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PiecesAuto::class,
        ]);
    }
}



/**  traitement de l'image dans le controller sous forme de formulaire*/
 /** @Route("/pieces/new", name="pieces_auto_new")

public function new(Request $request): Response
{
    $piece = new PiecesAuto();
    $form = $this->createForm(PieceAutoType::class, $piece);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $file = $form['chemin_image']->getData();
        if ($file) {
            $filename = uniqid() . '.' . $file->guessExtension();
            $file->move($this->getParameter('images_directory'), $filename);
            $piece->setCheminImage('images/' . $filename);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($piece);
        $entityManager->flush();

        return $this->redirectToRoute('pieces_auto');
    }

    return $this->render('pieces/new.html.twig', [
        'form' => $form->createView(),
    ]);
}
**/




class PieceController extends AbstractController
{
    #[Route('/ajouter-piece', name: 'piece.ajouter')]
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
        return $this->redirectToRoute('piece.liste');
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
    #[Route('/liste', name: 'piece.liste', methods: ['GET'])]
    public function listePiece(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pieces = $entityManager->getRepository(Piece::class)->findAll();
        return $this->render('ListPiece.html.twig', ['pieces' => $pieces]);
    }
}
