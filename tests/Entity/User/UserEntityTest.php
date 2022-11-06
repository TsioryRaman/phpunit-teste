<?php

namespace App\Tests\Entity\User;

use App\Entity\User;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserEntityTest extends WebTestCase
{
    use FixturesTrait;

    public function testUniqueEmailEntity()
    {
        self::bootKernel();
        $this->loadFixtureFiles([
            __DIR__ . '/UserFixtures.yaml'
        ]);
        $user = (new User())
            ->setEmail("user1@gmail.com")
            ->setPassword("0000");
        $error = self::$container->get('validator')->validate($user);

        $this->assertCount(1,$error);
    }

}