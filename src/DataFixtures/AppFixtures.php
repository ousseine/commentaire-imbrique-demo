<?php

namespace App\DataFixtures;

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

        for($i = 1; $i <= 100; $i++) {
            $post = new Post();
            $post->setTitle($faker->words($faker->numberBetween(5, 10), true))
                ->setSlug($this->slugger->slug($post->getTitle()))
                ->setSummary($faker->text(220))
                ->setContent($faker->paragraphs(10, true))
                ->setPublishedAt($faker->dateTimeBetween('-6 months', 'now'))
            ;

            $manager->persist($post);
        }

        $manager->flush();
    }
}
