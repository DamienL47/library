<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/book")
 */
class AdminBookController extends AbstractController
{
    /**
     * @Route("admin/", name="admin_app_book_index", methods={"GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('admin/index_book.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    /**
     * @Route("admin/new", name="admin_app_book_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BookRepository $bookRepository): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->add($book, true);

            return $this->redirectToRoute('admin_app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/new_book.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("admin/{id}", name="admin_app_book_show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('admin/show_book.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("admin/{id}/edit", name="admin_app_book_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->add($book, true);

            return $this->redirectToRoute('admin_app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/edit_book.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("admin/{id}/delete", name="admin_app_book_delete", methods={"POST"})
     */
    public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $bookRepository->remove($book, true);
        }

        return $this->redirectToRoute('admin_app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
