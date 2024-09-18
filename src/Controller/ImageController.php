<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ImageType;

class ImageController extends AbstractController
{
    /**
     * @Route("/upload", name="upload_image")
     */
    public function upload(Request $request): Response
    {
        $form = $this->createForm(ImageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Possibilité de gérer les erreurs si nécessaire
                }

                // Enregistrer le nom du fichier dans la base de données si nécessaire

                return $this->redirectToRoute('image_success');
            }
        }

        return $this->render('image/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/upload/success", name="image_success")
     */


    public function success(): Response
    {
        return new Response('Bravo ! L\'image téléchargée avec succès');
    }
}
