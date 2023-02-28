<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixture extends Fixture
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 50; $i++) {
            $user = new User();

            $user->setEmail($this->faker->email);
            $user->setPassword($this->faker->password);
            $user->setUsername($this->faker->firstName);
            $user->setIsActive((rand(0, 1)));
            $user->setCreatedAt(new \DateTime());

            if ($i == 0) $user->setRoles(['ROLE_SUPER_ADMIN']);
            if ($i == 1) $user->setRoles(['ROLE_AUTHOR']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
