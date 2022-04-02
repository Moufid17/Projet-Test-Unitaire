<?php

use App\Entity\Item;
use App\Entity\ToDoList;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    private Item $item;

    protected function setUp(): void
    {
        $this->item = new Item("Item1_name","Item1_content");
        //User
        $user = new User("daniel@gmail.com","Daniel", "Larssonsdqsd", "passwordTest", 24);
        // todolist
        $todolist = new ToDoList();
        $todolist->setOwner($user); // Set Owner
        $todolist->addItem($this->item); // Set ToDoList
        parent::setUp();
    }

    public function testValidDueToNameEmptyIsNotConsidered()
    {
        $this->item->setName("");
        // dd($this->item); // Voir l'item. Aucun changement de nom n'est effectuer.
        $this->assertNotEmpty($this->item->getName());
    }

    public function testValidDueToContentEmptyIsNotConsidered()
    {
        $this->item->setContent("");
        // dd($this->item); // Voir l'item. Aucun changement de content n'est effectuer.
        $this->assertNotEmpty($this->item->getContent());
    }

    public function testValidDueToNameIsNotEmpty()
    {
        $this->item->setName("Item1_name_new");
        // dd($this->item); // Voir l'item. Le nom est a été changé.
        $this->assertNotEmpty($this->item->getName());
    }

    public function testValidDueToContentIsNotEmpty()
    {
        $this->item->setContent("Item1_content_new");
        // dd($this->item); // Voir l'item. Le content a été changé.
        $this->assertNotEmpty($this->item->getContent());
    }
}