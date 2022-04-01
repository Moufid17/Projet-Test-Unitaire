<?php

namespace App\Tests;

use App\Entity\Item;
use App\Entity\ToDoList;
use PHPUnit\Framework\TestCase;

class ToDoListTest extends TestCase
{
    private ToDoList $todolist;

    protected function setUp(): void
    {
        $this->todolist = new ToDoList();
        parent::setUp();
    }
    
    public function testFirstOneItem()
    {
        $item1 = new Item("Item1_name","Item1_content");
        $this->todolist->addItem($item1);
        $this->assertEquals(1, $this->todolist->getItems()->count());
    }

    public function testSecondItemValidInterval()
    {
        $item1 = new Item("Item1_name","Item1_content");
        sleep(2);
        $item2 = new Item("Item2_name","Item2_content");
        $this->todolist->addItem($item1);
        $this->todolist->addItem($item2);
        // dd($tab);
        // $tab = [$item1, $item2];
        $this->assertEquals(2, $this->todolist->getItems()->count());
    }

    public function testSecondItemInvalidInterval()
    {
        $item1 = new Item("Item1_name","Item1_content");
        sleep(1);
        $item2 = new Item("Item2_name","Item2_content");
        $this->todolist->addItem($item1);
        $this->todolist->addItem($item2);
        $this->assertNotEquals(2, $this->todolist->getItems()->count());
    }

    public function testIsValidDueToTwoItemsHaveSameName()
    {
        $item1 = new Item("Item1_name","Item1_content");
        sleep(1);
        $item2 = new Item("Item1_name","Item2_content");
        $this->todolist->addItem($item1);
        $this->todolist->addItem($item2);
        // dd($this->todolist->getItems()->count());
        $this->assertEquals(1, $this->todolist->getItems()->count());
    }

    public function testAddElevenItem()
    {
        #Add 10 Items
        $itemCollection = [];
        for($i = 0; $i < 10; $i++) {
            $this->todolist->addItem(new Item("Item_name" . strval($i),"Item_content" . strval($i)));
            sleep(2);
        }
        
        // dd($this->todolist->getItems()->count());
        $this->todolist->addItem(new Item("Item11_name","Item11_content"));
        $this->assertEquals(10, $this->todolist->getItems()->count());
    }

}