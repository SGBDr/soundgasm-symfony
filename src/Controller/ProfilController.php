<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CreateUserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Entity\User;

#[Route('/profil')]
class ProfilController extends AbstractController
{
    #[Route('', name: 'app_profil')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
        $user->setPassword("");
        $form = $this->createForm(CreateUserType::class, $user);
        $form->handleRequest($request);

        $error = "";

        if ($form->isSubmitted()) {
            // encode the plain password
            $user->setCreationDate(new \DateTime());

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            
            $expressionReguliere = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/";

            if (preg_match($expressionReguliere, $form->get('password')->getData()) || trim($form->get('password')->getData()) == ""){
                
                $new_user = $this->getUser();

                if($user->getPassword() != "")$new_user->setPassword($user->getPassword());
                
                $user->setPassword($new_user->getPassword());

                $entityManager->persist($user);
                $entityManager->flush();
                
                return $this->redirectToRoute('app_profil');
            }

            $error = "";
        }


        return $this->render('profil/index.html.twig', [
            "name" => $this->getUser()->getName(),
            "registrationForm" => $form->createView(),
            "error" => ""
        ]);
    }
}
