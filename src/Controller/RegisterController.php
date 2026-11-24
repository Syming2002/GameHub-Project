<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        // on vérifie si la method est bien POST et on récupère les données saisies dans les champs
        if ($request->isMethod('POST')) {
            $nom = trim($request->request->get('userLastName'));
            $prenom = trim($request->request->get('userFirstName'));
            $email = trim($request->request->get('userEmail'));
            $password = trim($request->request->get('userPassword'));

            $roles = trim($request->request->get("userRoles"));


            if (!$this->isCsrfTokenValid(
                'register',
                $request->request->get('_csrf_token')
            )) {
                throw $this->createAccessDeniedException('Invalid Token CSRF');
            }

            if ($email === '' || $password === '') {
                $this->addFlash("error", "All fields must be filled");
                return $this->redirectToRoute("app_register");
            }

            $existingUser = $em
            ->getRepository(User::class)
            ->findOneBy(['userEmail' => $email]);

            if ($existingUser) {
                $this->addFlash('error', 'This email has been already used for creating an account');
                return $this->redirectToRoute("app_register");
            } 
            $user = new User();
            $user->setUserLastName($nom);
            $user->setUserFirstName($prenom);
            $user->setUserEmail($email);
            $passwordHashed = $hasher->hashPassword($user, $password);
            $user->setUserPassword($passwordHashed);

            $user->setUserType(['ROLE_USER']);
            
            // enregistrer dans la db
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Your account has been created");

            return $this->redirectToRoute('app_login');
        }

        

        return $this->render('register/index.html.twig', [
           
        ]);
    }
}
