<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ItemFixture extends Fixture
{
    private int $minItems = 1;
    private int $maxItems = 6;
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        $object = (new Item())
            ->setName($faker->name)
            ->setContent($faker->sentences(2))
            ->setCreationDate($faker->dateTime);

        $manager->persist($object);
        $manager->flush();
    }
}
