<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\ToDoList;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TodolistFixture extends Fixture implements DependentFixtureInterface
{
    private int $minTodoListSize = 1;
    private int $maxTodoListSize = 6;

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $items = $manager->getRepository(Item::class)->findAll();

        for ($todos = 0; $todos < 10; $todos++) {
            $todolist = new ToDoList();
            for ($i = $this->minTodoListSize; $i < $this->maxTodoListSize; $i++) {
                $todolist
                    ->addItem($faker->randomElement($items));
            }
            $manager->persist($todolist);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ItemFixture::class
        ];
    }
}
