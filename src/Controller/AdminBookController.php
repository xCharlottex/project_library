<?php
// - Faite un nouveau projet "library" avec symfony
//- faite une page d'accueil avec un message de bienvenue
//- faites des crud dans une zone d'admin pour deux entités : book et author
//- pour l'entité book, il faut : title, nbPages, author (relié à l'autre entité en many to one), publishedAt
//- pour l'entité author : firstName, lastName, birthDate, deathDate, books (one to many)
//- faites un peu de css (à peu près propre). vous pouvez utiliser un framework CSS
//- moteur de recherche sur les le titre des livres


namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminBookController extends AbstractController {


    /**
     * @Route("/admin/home", name="admin_home")
     */
    public function home(){
        return $this->render(('home.html.twig'));
    }

    /**
     * @Route("/admin/books", name="admin_books")
     */
    public function listBooks(BookRepository $bookRepository){
        $books = $bookRepository->findAll();

        return $this->render(('admin/books.html.twig'),[
            'books' => $books
        ]);
    }

    /**
     * @Route("/admin/book/{id}", name="admin_show_book")
     */
    public function showBook($id, BookRepository $bookRepository){
        $book = $bookRepository->find($id);

        return $this->render('admin/book.html.twig',[
           'book' => $book
        ]);
    }

    /**
     * @Route("/admin/insert_book", name="admin_insert_book")
     */
    public function insertBook(EntityManagerInterface $entityManager, Request $request){
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($book);
            $entityManager->flush();
        }
        return $this->render('admin/insert_book.html.twig',[
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/admin/book/update/{id}", name="admin_update_book")
     */
    public function updateBook($id, BookRepository $bookRepository,EntityManagerInterface $entityManager, Request $request){
        $book = $bookRepository->find($id);

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($book);
            $entityManager->flush();
        }
        return$this->render('admin/insert_book.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/book/delete/{id}", name="admin_delete_book")
     */
    public function deleteBook($id, BookRepository $bookRepository, EntityManagerInterface $entityManager){
        $book = $bookRepository->find($id);

        if (!is_null($book)){
            $entityManager->remove($book);
            $entityManager->flush();

        $this->addFlash('success', 'c\'est bon');
        } else {
        $this->addFlash('error', 'raté ce n\'est pas supp');
        }
        return $this->redirectToRoute('admin_books');
    }


    /**
     * @Route("/admin/books/search", name="admin_search_books")
     */
    public function searchBooks(Request $request, BookRepository $bookRepository, AuthorRepository $authorRepository){
        $search =$request->query->get('search');

        $books = $bookRepository->searchByword($search);

        return $this->render('admin/search_books.html.twig', [
            'books' => $books,
        ]);
    }
}

