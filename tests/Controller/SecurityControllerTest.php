<?php


namespace App\Tests\Controller;


use App\Tests\ServiceControllerTest;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends ServiceControllerTest
{
    use FixturesTrait;
    public function testDisplayLogin(){
        $this->getCrawler(Request::METHOD_GET,'/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains("h1","Se connecter");
    }

    public function testLoginWithBadCredentials(){
        $crawler = $this->getCrawler(Request::METHOD_GET,'/login');
        $form = $crawler->selectButton("Se connecter")->form([
            "email"=>"tsiory@test.fr",
            "password" =>"fakePassword"
        ]);
        $client = self::getClient();
        $client->submit($form);
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists(".alert.alert-danger");
    }

    public function testSuccessfullLogin(){

        $this->loadFixtureFiles([
            __DIR__ . '/Users.yaml'
        ]);

        $client = self::getClient();
        /**
        $crawler = $client->request(Request::METHOD_GET,'/login');
        $form = $crawler->selectButton("Se connecter")->form([
            "email"=>"tsiory@test.fr",
            "password" =>"000000"
        ]);
         * **/
        $csrfToken = $client->getContainer()->get('security.csrf.token_manager')->getToken('authenticate');
        $client->request('post','login',[
            '_csrf_token'=>$csrfToken,
            "email"=>"tsiory@test.fr",
            "password" =>"000000"
        ]);
        $this->assertResponseRedirects('/auth');
    }

}