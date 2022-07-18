<?php

namespace App\Controller;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AuthorType;
class AdminAuthorController extends AbstractController {

    /**
     * @Route("/admin/authors", name="admin_authors")
     */
    public function Authors( AuthorRepository $authorRepository){
        $authors = $authorRepository->findAll();

        return $this->render('admin/authors.html.twig', [
            'authors' => $authors
        ]);
    }


    /**
     * @Route("/admin/author/{id}", name="admin_show_author")
     */
    public function showAuthor($id, AuthorRepository $authorRepository){
        $author = $authorRepository->find($id);

        return $this->render('admin/author.html.twig', [
            'author' => $author

        ]);
    }

    /**
     * @Route("/admin/insert_author", name="admin_insert_author")
     */
    public function insertAuthor(EntityManagerInterface $entityManager, Request $request){
        //créer une instance de la classe author
        // creer un nouvel author (table author de ma BDD)

        $author = new Author();

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($author);
            $entityManager->flush();
        }
        return $this->render('admin/insert_author.html.twig',[
            'form' => $form->createView()

        ]);
    }

    /**
     * @Route("/admin/author/update/{id}", name="admin_update_author")
     */
    public function updateAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $entityManager, Request $request){
        $author = $authorRepository->find($id);

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($author);
            $entityManager->flush();
        }
        return $this->render('admin/insert_author.html.twig',[
            'form' => $form->createView()

        ]);
    }

    /**
     * @Route("/admin/author/delete/{id}", name="admin_delete_author")
     */
    public function deleteAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $entityManager){
        $author = $authorRepository->find($id);

        $entityManager->remove($author);
        $entityManager->flush();

        return $this->redirectToRoute('admin_authors');
    }



}