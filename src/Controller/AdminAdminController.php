<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminAdminController extends AbstractController
{

    /**
     * @Route("/admin/admins", name="admin_list_admins")
     */
    public function listAdmins(UserRepository $userRepository)
    {
        // j'utilise l'instance de classe User Repository pour afficher toutes les données de ma BDD
        $admins = $userRepository->findAll();
        // J'affiche le résultat sur une page twig avec la méthode render
        return $this->render('admin/admins.html.twig', [
            //Je parametre 'admins' pour appeler les éléments de ma base de données
            'admins' => $admins
        ]);
    }

    /**
     * @Route("/admin/create_admins", name="admin_create_admins")
     */
    public function createAdmin(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        //je créé une instance de la classe admin
        $user = new User();
        // j'affecte le rôle par défaut
        $user->setRoles(["ROLE_ADMIN"]);
        // je génère la vue du formulaire d'ajout d'admin
        $form = $this->createForm(UserType::class, $user);
        //j'utile l'instance de classe request pour récupérer la valeur des données du formulaire
        $form->handleRequest($request);
        //si le formulaire est soumis et est valide
        if ($form->isSubmitted() && $form->isValid()){
            //je récupère le password en clair depuis le formulaire
            $passwordUser = $form->get('password')->getData();
            //Je lui applique le Hash pour le crypter
            $hashedPassword = $userPasswordHasher->hashPassword($user, $passwordUser);
            //j'affecte le password hashé à l'user
            $user->setPassword($hashedPassword);
            //Je rassemble les données du formulaire pour préparer l'envoie en base de données
            $entityManager->persist($user);
            // j'envoie en base de données
            $entityManager->flush();
            // Je transmet un message flash de succes
            $this->addFlash('success', ' à bien été créé.');
            // je redirige vers la liste des admins
            return $this->redirectToRoute('admin_list_admins');
        }
        // Page d'admin sur laquelle est généré mon formulaire d'ajout
        return $this->render('admin/create_admin.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/update_admin/{id}", name="admin_update_admin")
     */
    public function updateAdmin(EntityManagerInterface $entityManager, Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
            $passwordUser = $form->get('password')->getData();
            //Je lui applique le Hash pour le crypter
            $hashedPassword = $userPasswordHasher->hashPassword($user, $passwordUser);
            //j'affecte le password hashé à l'user
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            // j'envoie en base de données
            $entityManager->flush();


            $this->addFlash('success', ' à bien été modifié.');

            return $this->redirectToRoute('admin_list_admins');
        }

        return $this->renderForm('admin/update_admin.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/delete/admin/{id}", name="admin_delete_admin")
     */
    public function deleteAdmin($id, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $user = $userRepository->find($id);
        if (!is_null($user)){
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', ' à bien été supprimé.');
            return $this->redirectToRoute('admin_list_admins');
        } else {
            return new Response('Utilisateur inexistant');
        }

    }

}