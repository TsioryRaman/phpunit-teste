<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i=0;$i<10;$i++)
        {
            $user = (new User())
                ->setEmail("user$i@cool.com")
                ->setPassword("0000");

            $manager->persist($user);
        }

        $manager->flush();
    }
}
