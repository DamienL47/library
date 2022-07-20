<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/author", name="index_author", methods={"GET"})
     */
    public function index(AuthorRepository $authorRepository): Response
    {
        return $this->render('index_author.html.twig', [
            'authors' => $authorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/author/{id}", name="show_author", methods={"GET"})
     */
    public function show(Author $author): Response
    {
        return $this->render('show_author.html.twig', [
            'author' => $author,
        ]);
    }
}