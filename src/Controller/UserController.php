<?php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;


//Update
class UserController extends AbstractController
{
    #[Route('/update', name: 'user_update')]
    public function updateUser(Request $request, EntityManagerInterface $entityManager): Response
    {
       //l'update va récupérer l'id qui est connecté
        $user = $this->getUser();

        if($request->getMethod() === 'POST') {
            //si la requête est de type post
            $name = $request->request->get('name');
            $firstname = $request->request->get('firstname');

                // je créais mon instance de class

                $user->setName($name);
                $user->setFirstname($firstname);

                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Le compte a été modifier avec succès');
        }

        return $this->render('userUpdate.html.twig', ['user' => $user]);
    }

    #[Route('/inscription', name: 'user.inscription')]
    public function inscription(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        //le comparatif se fait grâce au égal
        if($request->getMethod() === 'POST') {
        //si la requête est de type post
            $name = $request->request->get('name');
            $firstname = $request->request->get('firstname');
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $passwordConfirm = $request->request->get('passwordConfirm');

            if (!$email){
                $this->addFlash('fail', 'Il manque l\'adresse mail');
                return $this->render('Page2Inscription.html.twig');
            }

            if (!$password){
                $this->addFlash('fail', 'Il manque le mot de passe');
                return $this->render('Page2Inscription.html.twig');
            }

            if($password !== $passwordConfirm) {
                $this->addFlash('fail', 'Les mots de passe ne correspondent pas');
            } else{
                // je créais mon instance de class user
                $user = new User();

                $hashedPassword = $passwordHasher->hashPassword($user, $password);

                $user->setName($name);
                $user->setFirstname($firstname);
                $user->setEmail($email);
                $user->setRoles(['ROLE_USER']);
                $user->setPassword($hashedPassword);
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Le compte a été créé avec succès');

            }

        }

        return $this->render('Page2Inscription.html.twig');
    }

    #[Route('/connexion', name: 'user.connexion')]
    public function connexion(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        //le comparatif se fait grâce au égal
        if($request->getMethod() === 'POST') {
            //si la requête est de type post
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            if (!$email){
                $this->addFlash('fail', 'Il manque l\'adresse mail');
                return $this->render('Page3Connexion.html.twig');
            }

            if (!$password){
                $this->addFlash('fail', 'Il manque le mot de passe');
                return $this->render('Page3Connexion.html.twig');

            } else{
                // je créais mon instance de class user
                $user = new User();

                $hashedPassword = $passwordHasher->hashPassword($user, $password);

                $user->setEmail($email);
                $user->setRoles(['ROLE_USER']);
                $user->setPassword($hashedPassword);
                $entityManager->persist($user);
                $entityManager->flush();
                $this->render('userConnexion.html.twig', ['user' => $user]);
                $this->addFlash('success', 'Connexion correct');

            }
        }
        return $this->render('Page3Connexion.html.twig');
    }



    #[Route('/depot', name: 'user.depot')]
    public function depot(Request $request): Response
{
        return $this->render('Page4Depot.html.twig');
}

  

    #[Route('/page5ListPiece', name: 'user.pieceRef')]
    public function pieceRef(Request $request): Response
    {
        return $this->render('page5ListPiece.html.twig');
    }

    #[Route('/page6Regle', name: 'user.regle')]
    public function regle(Request $request): Response
    {
        return $this->render('page6Regle.html.twig');
    }

    //Delete
    #[Route('/delete', name: 'user.delete')]
    public function deleteUser(EntityManagerInterface $entityManager, Security $security): Response
{
    $currentUser = $this->getUser();
    $entityManager->remove($currentUser);
    $entityManager->flush();

    $security ->logout(false);

    $this->addFlash('success', 'le profile a été supprimé avec succès');

        return $this->redirectToRoute('user.inscription');
}
}