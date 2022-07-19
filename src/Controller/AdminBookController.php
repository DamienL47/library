<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/")
 */
class AdminBookController extends AbstractController
{
    /**
     * @Route("admin/book", name="admin_app_book_index", methods={"GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('admin/index_book.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    /**
     * @Route("admin/new_book", name="admin_app_book_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BookRepository $bookRepository, SluggerInterface $slugger): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Je récupère le fichier image depuis mon formulaire
            $image = $form->get('image')->getData();

            //Je récupère le nom du fichier original
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            // J'utilise une instance de la classe Slugger et sa méthode slug pour
            // supprimer les caractères spéciaux, espace ect du nom de fichier
            $safeFilename = $slugger->slug($originalFilename);

            // Je rajoute au nom de l'image, un identifiant unique (au cas ou l'image soit uploadée plusieurs fois)
            $fileName = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

            // je deplace l'image dans le dossier public et je la renomme avec le nouveau nom créé
            $image->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            $book->setImage($fileName);

            $bookRepository->add($book, true);

            return $this->redirectToRoute('admin_app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/new_book.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("admin/book/{id}", name="admin_app_book_show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('admin/show_book.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("admin/book/{id}/edit", name="admin_app_book_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Book $book, BookRepository $bookRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->add($book, true);

            $image = $form->get('image')->getData();

            //Je récupère le nom du fichier original
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            // J'utilise une instance de la classe Slugger et sa méthode slug pour
            // supprimer les caractères spéciaux, espace ect du nom de fichier
            $safeFilename = $slugger->slug($originalFilename);

            // Je rajoute au nom de l'image, un identifiant unique (au cas ou l'image soit uploadée plusieurs fois)
            $fileName = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

            // je deplace l'image dans le dossier public et je la renomme avec le nouveau nom créé
            $image->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            $book->setImage($fileName);

            return $this->redirectToRoute('admin_app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/edit_book.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("admin/book/{id}/delete", name="admin_app_book_delete", methods={"POST"})
     */
    public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $bookRepository->remove($book, true);
        }

        return $this->redirectToRoute('admin_app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
