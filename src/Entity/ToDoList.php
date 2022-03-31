<?php

namespace App\Entity;

use App\Repository\ToDoListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            if($this->checkItem()){
                $this->items[] = $item;
                $item->setTodolist($this);
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
    
    private function checkItem(): bool
    {
        // Compter le nombre d'item déjà enregistrés
        $itemsCollection = $this->getItems();
        $nb_items = count($itemsCollection);
        # Est-ce la bonne manière.
        #$lastItem_dateCreated = $itemsCollection[$nb_items - 1 ].getCreationDate();
        // S'il y a 10 items, rien ne sera fait.
        if ($nb_items == 0) {
            return true;
        }
        if ($nb_items > 0 && $nb_items < 10) { //Critère 2 : vrai
            $lastItem_dateCreated = $itemsCollection->last()->getCreationDate();
            # Comment comparer deux dates?
            # https://www.php.net/manual/fr/datetime.diff.php
/*            if ((new \DateTime('now'))->diff($lastItem_dateCreated)->m > 30) {
                return true;
            }*/
            if ((new \DateTime('now'))->diff($lastItem_dateCreated)->s > 5) {
                return true;
            }
/*            if((new \DateTime('now') - $lastItem_dateCreated)> 30){ // Critère 4 : Vrai
                return true;
            }*/
        }
        return false;
    }
}
