<?php 

use PHPUnit\Framework\TestCase;

class test extends TestCase
{

    public function testAdd()
    {
        $this->assertEquals(5,5);
    }
}

/*
dd();

docker-compose exec php bin/phpunit tests/test.php

docker-compose exec php bin/phpunit --testdox tests/ToDoListTest.php

 */