<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *  max = 1000   
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="date")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity=ToDoList::class, inversedBy="items")
     */
    private $todolist;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getTodolist(): ?ToDoList
    {
        return $this->todolist;
    }

    public function setTodolist(?ToDoList $todolist): self
    {
        $this->todolist = $todolist;

        return $this;
    }
}
