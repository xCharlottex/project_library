<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
//- pour l'entité author : firstName, lastName, birthDate, deathDate, books (one to many)
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use App\Repository\AuthorRepository;


/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 */
class Author {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column (type="integer")
     */
    private $id;


    /**
     * @ORM\Column (type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column (type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\OneToMany (targetEntity="App\Entity\Book", mappedBy="author")
     */
    private $books;
    // clé étrangère créé , et crée la relation d'un article relié à un book

    /**
     * @ORM\Column (type="date")
     */
    private $birthDate;

    /**
     * @ORM\Column (type="date")
     */
    private $deathDate;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastname): self
    {
        $this->lastName = $lastname;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getDeathDate()
    {
        return $this->deathDate;
    }

    /**
     * @param mixed $deathDate
     */
    public function setDeathDate($deathDate): void
    {
        $this->deathDate = $deathDate;
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setAuthor($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null);
            }
        }

        return $this;
    }
}