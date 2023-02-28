<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function __construct(
        private CategoryRepository $categoryRepo,
        private UserRepository $userRepo,
    )
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 100; $i++) {

        $categories = $this->categoryRepo->findAll();
        $randomKey = array_rand($categories);
        $category = $categories[$randomKey];

        $users = $this->userRepo->findAll();

        $article = new Article();

        $article->setCategory($category)
                ->setAuthor($users[1])
                ->setTitle($this->faker->words(10, true))
                ->setContent($this->faker->text(rand(20, 50)))
                ->setSlug($this->faker->words(10, true))
                ->setFeaturedText($this->faker->text(rand(20, 50)))
                ->setStatus(1)
                ->setCreatedAt(new \DateTime())
        ;

        $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
        );

    }
}