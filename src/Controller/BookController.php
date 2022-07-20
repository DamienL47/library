<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{

    /**
     * @Route("/book", name="index_book", methods={"GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('index_book.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/book/{id}", name="show_book", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('show_book.html.twig', [
            'book' => $book,
        ]);
    }
}