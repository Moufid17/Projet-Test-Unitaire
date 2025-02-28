<?php

namespace App\Entity;

use App\Repository\ToDoListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

// ExternalServices \EmailSenderService
use App\ExternalServices\EmailSenderService;

/**
 * @ORM\Entity(repositoryClass=ToDoListRepository::class)
 */
class ToDoList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="todolist", cascade={"persist", "remove"})
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=Item::class, mappedBy="todolist")
     */
    private $items;

    public function __construct()
    {
        $this->id = time() - rand(17000,25000);
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        // unset the owning side of the relation if necessary
        if ($owner === null && $this->owner !== null) {
            $this->owner->setTodolist(null);
        }

        // set the owning side of the relation if necessary
        if ($owner !== null && $owner->getTodolist() !== $this) {
            $owner->setTodolist($this);
        }

        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item, EmailSenderService $emailSenderMessage = null): self
    {
        if (!$this->items->contains($item)) {
            if($this->checkToDoListItems()){
                if($this->checkItemName($item->getName())){
                    // External Service
                    if(count($this->getItems()) == 7){
                        if($emailSenderMessage !== null){
                            $this->getOwner()->addMessage($emailSenderMessage->sendEmail());
                        }
                    }
                    // -----------------
                    
                    $this->items[] = $item;
                    $item->setTodolist($this);
                }
            }
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getTodolist() === $this) {
                $item->setTodolist(null);
            }
        }

        return $this;
    }
    
    private function checkToDoListItems(): bool
    {
        // Compter le nombre d'item déjà enregistrés
        $itemsCollection = $this->getItems();
        $nb_items = count($itemsCollection);
        
        // if($nb_items == 10){
        //     print("ToDoList : Add item collection is full. bye.");
        // }
        
        // S'il y a 10 items, rien ne sera fait.
        if ($nb_items == 0) {
            return true;
        }

        if ($nb_items > 0 && $nb_items < 10) { //Critère 2 : vrai
            $lastItem_dateCreated = $itemsCollection->last()->getCreationDate();
            
            // Interval de temps : 30 minutes
            if ((new \DateTime('now'))->diff($lastItem_dateCreated)->m >= 30) {
                return true;
            }

            // Interval de temps : 2 secondes
            // if ((new \DateTime('now'))->diff($lastItem_dateCreated)->s >= 2) {
            //     return true;
            // }
        }
        return false;
    }

    public function checkItemName($name){
        $itemsCollection = $this->getItems();

        if($itemsCollection !== null){
            // Unique name
            foreach($itemsCollection as $item){
                if($item->getName() == $name){
                    // if(strval($item->getId()) == strval($this->getId())){
                    //     return true;
                    // }
                    return false;
                }
                
            }
        }
        return true;
    }
}
