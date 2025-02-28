<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\OneToOne(targetEntity=ToDoList::class, inversedBy="owner", cascade={"persist", "remove"})
     */
    private $todolist;

    /**
     * ArrayCollection
     */
    private $inbox;

    /**
     * @param $id
     * @param $email
     * @param $firstname
     * @param $lastname
     * @param $password
     * @param $age
     * @param $todolist
     */
    public function __construct($email, $firstname, $lastname, $password, $age)
    {
        $this->id = time() - rand(25000,30000);
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->age = $age;
        $this->todolist = null;
        $this->inbox = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getTodolist(): ?ToDoList
    {
        return $this->todolist;
    }

    public function setTodolist(?ToDoList $todolist): self
    {
        if($this->checkToDoList() == false){
            $this->todolist = $todolist;
        }
        return $this;
    }

    public function isValid(): bool
    {
        return !empty($this->email)
            && filter_var($this->email, FILTER_VALIDATE_EMAIL)
            && !empty($this->firstname)
            && !empty($this->lastname)
            && !empty($this->password)
            && (strlen($this->password) < 41)
            && (strlen($this->password) >= 8)
            && !empty($this->age)
            && (gettype($this->age) == 'integer')
            && ($this->age >= 13)
        ;
    }

    private function checkToDoList(): bool
    {
        # Vérifier si l'utilisateur à une todolist
        return ($this->getTodolist() !== null); 
    }

    public function addMessage(string $message): void{
        $this->inbox[] = $message;
    }

    public function getInbox(): collection
    {
        return $this->inbox;
    }
}
