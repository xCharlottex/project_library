<?php
// - Faite un nouveau projet "library" avec symfony
//- faite une page d'accueil avec un message de bienvenue
//- faites des crud dans une zone d'admin pour deux entités : book et author
//- pour l'entité book, il faut : title, nbPages, author (relié à l'autre entité en many to one), publishedAt
//- pour l'entité author : firstName, lastName, birthDate, deathDate, books (one to many)
//- faites un peu de css (à peu près propre). vous pouvez utiliser un framework CSS
//- moteur de recherche sur les le titre des livres


namespace App\Controller\FrontController;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class FrontBookController extends AbstractController {


    /**
     * @Route("/home", name="home")
     */
    public function home(){
        return $this->render(('home.html.twig'));
    }

    /**
     * @Route("/books", name="books")
     */
    public function listBooks(BookRepository $bookRepository){
        $books = $bookRepository->findAll();

        return $this->render(('front/books.html.twig'),[
            'books' => $books
        ]);
    }

    /**
     * @Route("/book/{id}", name="show_book")
     */
    public function showBook($id, BookRepository $bookRepository){
        $book = $bookRepository->find($id);

        return $this->render('front/book.html.twig',[
           'book' => $book
        ]);
    }



    /**
     * @Route("/books/search", name="search_books")
     */
    public function searchBooks(Request $request, BookRepository $bookRepository, AuthorRepository $authorRepository){
        $search =$request->query->get('search');

        $books = $bookRepository->searchByword($search);

        return $this->render('front/search_books.html.twig', [
            'books' => $books,
        ]);
    }
}

