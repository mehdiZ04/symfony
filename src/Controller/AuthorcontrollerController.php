<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorcontrollerController extends AbstractController
{
    #[Route('/authors', name: 'app_authors')]
    public function index(): Response
    {
        return $this->render('authors/index.html.twig', [
            'controller_name' => 'AuthorsController',
        ]);
    }

      #[Route('/showAuthors', name: 'app_showauthors')]
    public function showauthors(AuthorRepository $authorRepo): Response
    {
        $a= $authorRepo->trieAsc();
        return $this->render('authorcontroller/showauthors.html.twig', [
            'listauthor' => $a,
        ]);
    }


     #[Route('/add', name: 'app_addauthors')]
    public function add(ManagerRegistry $m): Response
    {
        $em=$m->getManager();
        $author=new Author();
        $author->setUsername("oussema");
        $author->setEmail("oussema@esprit.tn");
        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute('app_showauthors');
    }

    //amine jouini: +2
    #[Route('/deleteauthores/{id}', name: 'app_deleteauthors')]
    public function deleteauthores(ManagerRegistry $m ,AuthorRepository $a, $id ): Response
    {
        $em=$m->getManager();
        $f=$a->find($id);
        $em->remove($f);
        $em->flush();
        
        return $this->redirectToRoute('app_showauthors');
    }
    //mehd zouaghi+5
    #[Route('/editauthores/{id}', name: 'app_editauthors')]
    public function editauthores(Request $request, ManagerRegistry $m ,AuthorRepository $a, $id ): Response
    {
        $em=$m->getManager();
        $f=$a->find($id);
        $form=$this->createForm(AuthorType::class,$f);
        if( $form->isSubmitted() && $form->isValid()){
            $form->handleRequest($request);
            $em->persist($f);
            $em->flush();
            return $this->redirectToRoute('app_showauthors');
        }
        
        
        return $this->render('authorcontroller/editauthors.html.twig', [
            'f' => $form,
        ]);

    }
    #[Route('/Addauthores', name: 'addauthors')]
     public function Addauthores(Request $request, ManagerRegistry $m ): Response
    {
        $em=$m->getManager();
        $f=new Author();
        $form=$this->createForm(AuthorType::class,$f);
        
        $form->handleRequest($request);
        if( $form->isSubmitted() && $form->isValid()){
            
            $em->persist($f);
            $em->flush();
            return $this->redirectToRoute('app_showauthors');
        }
        
        
        return $this->render('authorcontroller/Addauthors.html.twig', [
            'f' => $form,
        ]);

    }
    

}
