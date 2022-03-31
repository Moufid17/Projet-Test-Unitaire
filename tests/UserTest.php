<?php

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp():void
    {
        $this->user = new User("daniel@gmail.com","Daniiel", "Larssonsdqsd", "passwordTest", 24);
        parent::setUp();
    }

    public function testIsValidNominal()
    {
        $this->assertTrue($this->user->isValid());
    }

    public function testNotValidDueToEmailIsEmpty()
    {
        $this->user->setEmail("");
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToEmailIsWrong()
    {
        $this->user->setEmail("aaaa.Com");
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToFirstName()
    {
        $this->user->setFirstname("");
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToLastName()
    {
        $this->user->setLastname("");
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToPwdIsEmpty()
    {
        $this->user->setPassword("");
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToPwdIsWrong()
    {
        $this->user->setPassword("123456");
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToAgeTypeIsWrong()
    {
        $this->user->setAge("12");
        $this->assertFalse($this->user->isValid());
    }

    public function testNotValidDueToAgeIsWrong()
    {
        $this->user->setAge(12);
        $this->assertFalse($this->user->isValid());
    }
}