<?php

namespace App\DataFixtures;

use App\Entity\ToDoList;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private int $numberOfUsers = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $todolist = $manager->getRepository(ToDoList::class)->findAll();

        for ($i = 0; $i < $this->numberOfUsers; $i++) {
            $object = (new User())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setAge($faker->numberBetween(7, 100))
                ->setEmail($faker->email)
                ->setPassword($faker->password(8, 40))
                ->setTodolist($faker->randomElement($todolist));
            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TodolistFixture::class
        ];
    }
}
