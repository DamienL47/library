<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/author")
 */
class AdminAuthorController extends AbstractController
{
    /**
     * @Route("admin/", name="app_admin_author_index", methods={"GET"})
     */
    public function index(AuthorRepository $authorRepository): Response
    {
        return $this->render('admin/index_author.html.twig', [
            'authors' => $authorRepository->findAll(),
        ]);
    }

    /**
     * @Route("admin/new_author", name="app_admin_author_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AuthorRepository $authorRepository): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $authorRepository->add($author, true);

            return $this->redirectToRoute('app_admin_author_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/new_author.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    /**
     * @Route("admin/author/{id}", name="app_admin_author_show", methods={"GET"})
     */
    public function show(Author $author): Response
    {
        return $this->render('admin/show_author.html.twig', [
            'author' => $author,
        ]);
    }

    /**
     * @Route("admin/author/{id}/edit", name="app_admin_author_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Author $author, AuthorRepository $authorRepository): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $authorRepository->add($author, true);

            return $this->redirectToRoute('app_admin_author_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/edit_author.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    /**
     * @Route("admin/author/{id}/delete", name="app_admin_author_delete", methods={"POST"})
     */
    public function delete(Request $request, Author $author, AuthorRepository $authorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $authorRepository->remove($author, true);
        }

        return $this->redirectToRoute('app_admin_author_index', [], Response::HTTP_SEE_OTHER);
    }
}
