<?php


namespace App\Tests\Controller;

use App\Tests\NeedLogin;
use App\Tests\ServiceControllerTestUtil;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageControllerTestUtil extends ServiceControllerTestUtil
{
    use FixturesTrait;
    use NeedLogin;
    public function testHelloPage(){
        $this->getCrawler(Request::METHOD_GET,"/hello");
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testH1HelloPage(){

        $this->getCrawler(Request::METHOD_GET,"/hello");
        $this->assertSelectorTextContains("h1","Bienvenue sur mon site");
    }

    public function testAuthPageIsRestricted(){

        $this->getCrawler(Request::METHOD_GET,"/auth");
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testRedirectToLogin(){
        $this->getCrawler(Request::METHOD_GET,"/auth");
        $this->assertResponseRedirects("/login");
    }

    public function testLetAuthenticatedUserAccess()
    {
        $client = self::createClient();
        $users = $this->loadFixtureFiles([
            __DIR__ . '/Users.yaml'
        ]);
        $this->login($client,$users["user_simple"]);

        $client->request(Request::METHOD_GET,'/auth');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    }

    public function testAdminRequireRole()
    {
        $client = self::createClient();
        $users = $this->loadFixtureFiles([
            __DIR__ . '/Users.yaml'
        ]);

        $this->login($client,$users["user_admin"]);
        $client->request(Request::METHOD_GET,'/admin');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}