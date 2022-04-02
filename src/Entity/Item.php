<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
// class Item extends ItemBase
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


    public function __construct($name, $content)
    {
        # Comment le faire ? Optionel pour le projet.
        // $em = $this->setEntityManager(EntityManagerInterface);

        // $itemsCollection =  $this->em->getRepository(ItemRepository::class)->findAll(); 
        
        // if($itemsCollection->count() == 0){
        //     $this->id = 1;
        // }else if($itemsCollection->count() > 0){
        //     $this->id = $itemRepository->findAll()->last()->getId() + 1;
        // }
        $this->id = time() - rand(1000,17000);
        $this->name = $name;
        $this->content = $content;
        $this->creationDate = new \DateTime('now');
    }

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
        if($this->isValid($name)){
            $this->name = $name;
        }
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        if($this->isValid($content)){
            $this->content = $content;
        }
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

    public function isValid($params):bool
    {
       
        // All items
        $itemsCollection = $this->getTodolist()->getItems();
        
        if(strlen($params) == 0){
            // print("\n-- Empty Error !\n");
            return false;
        }
        if($itemsCollection !== null){
            // Unique name
            foreach($itemsCollection as $item){
                if($item->getName() == $this->getName()){
                    if(strval($item->getId()) == strval($this->getId())){
                        return true;
                    }
                    return false;
                }
                
            }
        }
        // Content size less than 1000
        return (strlen($this->getContent()) <= 1000);
    }
}
