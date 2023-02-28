<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();

            $category->setName($this->faker->words(1, true))
                     ->setColor($this->faker->safeColorName)
                     ->setCreatedAt(new \DateTime())
            ;

            $manager->persist($category);
        }

        $manager->flush();
    }
}