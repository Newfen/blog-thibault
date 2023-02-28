<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function __construct(
        private ArticleRepository $articleRepo,
        private UserRepository $userRepo,
    )
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 300; $i++) {

        $articles = $this->articleRepo->findAll();
        $randomKey = array_rand($articles);
        $article = $articles[$randomKey];

        $users = $this->userRepo->findAll();
        $randomKey = array_rand($users);
        $user = $users[$randomKey];

            $comment = new Comment();

            $comment->setArticle($article)
                    ->setAuthor($user)
                    ->setContent($this->faker->text(rand(20, 50)))
                    ->setIsActive((rand(0, 1)))
                    ->setCreatedAt(new \DateTime())
            ;

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ArticleFixtures::class,
        );

        return array(
            UserFixture::class,
        );

    }
}