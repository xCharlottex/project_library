<?php

namespace App\Entity;

//- pour l'entité book, il faut : title, nbPages, author (relié à l'autre entité en many to one), publishedAt
// ORM = mapping objet-relationnel ; outil qui va permettre de se mettre en interface entre le programme et la BDD
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use App\Repository\BookRepository;


/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
// créer une class
class Book {

    // creer les annotations pour definir ce qu'il va etre créé dans la BDD
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column (type="string", length=255)
     */
    // type string = chaine de caractere
    private $title;

    // recupere avec book tous les author qui lui sont liés(qui possede l'id de l'author)
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="books")
     */
    private $author;

    /**
     * @ORM\Column(type="date")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPages;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @ORM\Column (type="string")
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param mixed $publishedAt
     */
    public function setPublishedAt($publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }





    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author): self
    {
        $this->author = $author;

        return $this;
    }

    public function setNbPages(int $nbPages): self
    {
        $this->nbPages = $nbPages;

        return $this;
    }

    public function getnbPages(): ?int
    {
        return $this->nbPages;
    }


    // pour creer une base de donnée dans le terminal :
    // php bin/console doctrine:database:create
    // migration de fichier dans la BDD
    // php bin/console make:migration
    // envoyer et comparer de la BDD précédente pour le prendre en compte
    // php bin/console doctrine:migration:migrate

    // php bin/console make:entity
    // pour creer ta nouvelle table




}