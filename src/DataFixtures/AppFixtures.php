<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    private function encode($user, $plaintextpassword)
    {
        return $this->passwordEncoder->encodePassword(
            $user,
            $plaintextpassword
        );
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($j = 0; $j < 10; $j++) {
            $oneUser = new User();
            $oneUser->setNickname($faker->word());
            $oneUser->setPassword($this->encode($oneUser, "mdp"));
            $oneUser->setEmail($faker->text(255));
            $oneUser->setWebsite($faker->text(255));
            $manager->persist($oneUser);
            for ($i = 0; $i < 10; $i++) {
                $onePost = new Post();
                $onePost->setTitle($faker->word());
                $onePost->setCategory($faker->word());
                $onePost->setContent($faker->text(255));
                $onePost->setUrlImage($faker->imageUrl($width = 640, $height = 480));
                $onePost->setAuthor($oneUser);
                $manager->persist($onePost);
            }
        }
        $manager->flush();
    }
}
