<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ItemFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $object = (new Item())
                ->setName($faker->name)
                ->setContent($faker->word)
                ->setCreationDate($faker->dateTime);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
