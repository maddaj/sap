<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 40; $i++) {
            $onePost = new Post();
            $onePost->setTitle($faker->word());
            $onePost->setCategory($faker->word());
            $onePost->setContent($faker->text(255));
            $onePost->setUrlImage($faker->imageUrl($width = 640, $height = 480));
            $manager->persist($onePost);
        }
        $manager->flush();
    }
}
