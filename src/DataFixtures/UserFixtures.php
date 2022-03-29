<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private int $numberOfUsers = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < $this->numberOfUsers; $i++) {
            $object = (new User())
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setAge($faker->numberBetween(7, 100))
                ->setEmail($faker->email)
                ->setPassword($faker->password(8, 40));
            $manager->persist($object);
        }
        $manager->flush();
    }
}
