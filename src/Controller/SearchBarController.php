<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SearchBarController extends AbstractController
{

    /**
     * @Route("search", name="search_bar")
     */
    public function searchBar(Request $request, AuthorRepository $authorRepository, BookRepository $bookRepository)
    {
        $search = $request->query->get('search');
        $authors = $authorRepository->searchByWord($search);
        $books = $bookRepository->searchByWord($search);

        return $this->render('search.html.twig', [
            'authors' => $authors,
            'books' => $books
        ]);
    }
}