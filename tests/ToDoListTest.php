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
        $item1 = new Item();
        $this->todolist->addItem($item1);
        $this->assertEquals(1, $this->todolist->getItems()->count());
    }

    public function testSecondItemValidInterval()
    {
        $item1 = new Item();
        sleep(7);
        $item2 = new Item();
        $this->todolist->addItem($item1);
        $this->todolist->addItem($item2);
        $this->assertEquals(2, $this->todolist->getItems()->count());
    }

    public function testSecondItemInvalidInterval()
    {
        $item1 = new Item();
        sleep(4);
        $item2 = new Item();
        $this->todolist->addItem($item1);
        $this->todolist->addItem($item2);
        $this->assertNotEquals(2, $this->todolist->getItems()->count());
    }

}