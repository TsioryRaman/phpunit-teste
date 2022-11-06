<?php

namespace App\Tests\Repository\UserRepository;

use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    use FixturesTrait;


    public function testTestUserRepository()
    {
        self::bootKernel();
        $this->loadFixtureFiles([
            __DIR__ . '/UserRepositoryFixtures.yaml'
        ]);
        $users = self::$container->get(UserRepository::class)->count([]);
        $this->assertEquals(10,$users);
    }

}