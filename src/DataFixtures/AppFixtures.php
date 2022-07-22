<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // create posts
        for($i = 1; $i <= 100; $i++) {
            $post = new Post();

            $post->setTitle($faker->words(5, true))
                ->setSlug($this->slugger->slug($post->getTitle()))
                ->setSummary($faker->text(220))
                ->setContent($faker->paragraphs($faker->numberBetween(10, 20), true))
                ->setPublishedAt($faker->dateTimeBetween('-6 months', 'now'))
            ;

            $manager->persist($post);

            // create comments
            for ($j = 1; $j <= mt_rand(2, 5); $j++) {
                $comment = new Comment();

                $date = '-'.(new \DateTime())->diff($post->getPublishedAt())->days.' days';

                $comment->setName($faker->firstName.' '.$faker->lastName)
                    ->setEmail($this->slugger->slug($comment->getName()).'@gmail.com')
                    ->setMessage($faker->paragraphs($faker->numberBetween(1, 3), true))
                    ->setPost($post)
                    ->setPublishedAt($faker->dateTimeBetween($date))
                ;

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
