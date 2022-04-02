<?php

namespace App\Tests;

use App\Entity\Item;
use App\Entity\ToDoList;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
// ExternalServices \EmailSenderService
use App\ExternalServices\EmailSenderService;

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
        // Interval de temps : 30 minutes
        sleep(30*60);

        // Interval de temps : 2 secondes
        // sleep(2);
        
        $item2 = new Item("Item2_name","Item2_content");
        $this->todolist->addItem($item1);
        $this->todolist->addItem($item2);

        $this->assertEquals(2, $this->todolist->getItems()->count());
    }

    public function testSecondItemInvalidInterval()
    {
        $item1 = new Item("Item1_name","Item1_content");
        // Interval de temps : 29 minutes
        sleep(29*60);
        // Interval de temps : 1 seconde
        // sleep(1);

        $item2 = new Item("Item2_name","Item2_content");
        $this->todolist->addItem($item1);
        $this->todolist->addItem($item2);

        $this->assertNotEquals(2, $this->todolist->getItems()->count());
    }

    public function testIsValidDueToTwoItemsHaveSameNameIsNotConsidered()
    {
        $item1 = new Item("Item1_name","Item1_content");
        // Interval de temps : 30 minutes
        sleep(30*60);
        // Interval de temps : 2 secondes
        // sleep(2);

        $item2 = new Item("Item1_name","Item2_content");
        $this->todolist->addItem($item1);
        $this->todolist->addItem($item2);

        // dd($this->todolist->getItems()->count());
        $this->assertEquals(1, $this->todolist->getItems()->count());
    }

    public function testAddElevenItem()
    {
        #Add 10 Items
        for($i = 0; $i < 10; $i++) {
            $this->todolist->addItem(new Item("Item_name" . strval($i),"Item_content" . strval($i)));
            // Interval de temps : 30 minutes
            sleep(30*60);
            // Interval de temps : 2 secondes
            // sleep(2);
        }
        
        // dd($this->todolist->getItems()->count());
        $this->todolist->addItem(new Item("Item11_name","Item11_content"));
        $this->assertEquals(10, $this->todolist->getItems()->count());
    }

    public function testSendEmailOnAddEighthItem()
    {
        #Add 7 Items
        for($i = 0; $i < 7; $i++) {
            $this->todolist->addItem(new Item("Item_name" . strval($i),"Item_content" . strval($i)));
            // Interval de temps : 30 minutes
            sleep(30*60);
            // Interval de temps : 2 secondes
            // sleep(2);
        }

        //Set Owner
        $user = new User("daniel@gmail.com","Daniel", "Larssonsdqsd", "passwordTest", 24);
        $this->todolist->setOwner($user);

        //Define Mock
        $emailSender = $this->getMockBuilder(EmailSenderService::class)->getMock();

        //Set Mock method retuen value 
        $emailSender->expects($this->any())
                ->method('sendEmail')
                ->willReturn("Il ne peut plus quʼajouter 2 items.");
        
        //Add eigth item
        $this->todolist->addItem(new Item("Item8_name","Item8_content"), $emailSender);

        //Get Owner Inbox
        $userInbox = $this->todolist->getOwner()->getInbox();

        // Test with last message.
        $this->assertSame("Il ne peut plus quʼajouter 2 items.", $userInbox[count($userInbox) - 1]);
    }

}