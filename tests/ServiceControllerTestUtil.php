<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServiceControllerTestUtil extends WebTestCase
{
    const client = null;

    public static function getClient(){
        if(self::client === null){
            return self::createClient();
        }
        return self::client;
    }

    public static function getCrawler(string $method,string $url){
        $client = self::getClient();
        $crawler = $client->request($method,$url);
        return $crawler;
    }
}