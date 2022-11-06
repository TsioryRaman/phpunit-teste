<?php

namespace App\Tests\Entity;

use App\Entity\InvitationCode;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InvitationCodeEntityTest extends WebTestCase
{

    use FixturesTrait;

    public function testValidEntity()
    {
        $this->assertAsError($this->getEntity(),0);
    }

    public function testInvalidCodeEntity()
    {
        $this->assertAsError($this->getEntity()->setCode("123"),1);
        $this->assertAsError($this->getEntity()->setCode("1234567"),1);

    }

    public function testInvalidBlankCodeEntity()
    {
        $this->assertAsError($this->getEntity()->setCode(""),1);
    }


    public function testInvalidBlankDescriptionEntity()
    {
        $this->assertAsError($this->getEntity()->setDescription(""),1);
    }

    public function testInvalidDoubleUsedCodeEntity()
    {
        $this->loadFixtureFiles([
            __DIR__ . '/InvitationCodeTestFixtures.yaml'
        ]);
        $this->assertAsError($this->getEntity()->setCode("54321"),1);
    }

    private function getEntity():InvitationCode
    {
        return (new InvitationCode())
            ->setCode("12345")
            ->setDescription("Ma petite description")
            ->setExpireAt(new \DateTime());
    }

    private function assertAsError(InvitationCode $code, int $error_count = 0)
    {
        self::bootKernel();
        $error = self::$container->get('validator')->validate($code);
        $this->assertCount($error_count,$error);
    }

}