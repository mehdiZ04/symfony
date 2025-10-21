<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Book;
use App\Form\BookType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\AuthorRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/show', name: 'app_showbook')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $books = $doctrine->getRepository(Book::class)->findAll();
        return $this->render('book/showbook.html.twig', [
            'listbook' => $books,
        ]);
    }
    #[Route('/addbook', name: 'app_addbook')]
    public function addbook(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(BookType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_showbook');
        }

        return $this->render('book/addbook.html.twig', [
            'controller_name' => 'BookController',
            'form' => $form,
        ]);
    }
    #[Route('/editbook/{id}', name: 'app_editbook')]
    public function editbook(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $book = $doctrine->getRepository(Book::class)->find($id);
        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('app_showbook');
        }

        return $this->render('book/editbook.html.twig', [
            'controller_name' => 'BookController',
            'form' => $form,
        ]);
    }
    #[Route('/deletebook/{id}', name: 'app_deletebook')]
    public function deletebook(ManagerRegistry $doctrine, $id): Response{
        $entityManager = $doctrine->getManager();
        $book = $doctrine->getRepository(Book::class)->find($id);
        if ($book) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_showbook');
    }

}