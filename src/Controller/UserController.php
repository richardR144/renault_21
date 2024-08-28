<?php
namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    #[Route('/insert', name: 'user_insert')]
    public function insertUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        if ($request->getMethod() === 'POST') {
            $name = $request->request->get(key: 'name');
            $firstname = $request->get(key: 'firstname');
            $email = $request->request->get(key: 'email');
            $password = $request->request->get(key: 'password');

            if (!$name) {
                $this->addFlash(type: 'failure', message: 'Il manque ton nom');
                return $this->render(view: 'publicView/page/user/insertUser.html.twig');
            }
            if (!$firstname) {
                $this->addFlash(type: 'failure', message: 'Il manque ton first prénom');
                return $this->render(view: 'publicView/page/user/insertUser.html.twig');
            }
            if (!$email) {
                $this->addFlash(type: 'failure', message: 'Il manque ton email');
                return $this->render(view: 'publicView/page/user/insertUser.html.twig');
            }
            if (!$password) {
                $this->addFlash(type: 'failure', message: 'Il manque ton mot de passe');
                return $this->render(view: 'publicView/page/user/insertUser.html.twig');
            }

            //créer un utilisateur (instance de class) pour pouvoir utiliser la classe user

            $user = new User();

            $user->setName($name);
            $user->setFirstname($firstname);
            $user->setEmail($email);
            $user->setPassword($password);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(type: 'success', message: 'L\'utilisateur a été enregistré avec success');
            }
        return $this->render(view: 'publicView/page/user/insertUser.html.twig');
}
}