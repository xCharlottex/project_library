<?php

namespace App\Controller\FrontController;
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
class FrontAuthorController extends AbstractController {

    /**
     * @Route("/authors", name="authors")
     */
    public function Authors( AuthorRepository $authorRepository){
        $authors = $authorRepository->findAll();

        return $this->render('front/authors.html.twig', [
            'authors' => $authors
        ]);
    }


    /**
     * @Route("/author/{id}", name="show_author")
     */
    public function showAuthor($id, AuthorRepository $authorRepository){
        $author = $authorRepository->find($id);

        return $this->render('front/author.html.twig', [
            'author' => $author

        ]);
    }


}