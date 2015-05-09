<?php

namespace AppBundle\Tests\Controller;

use Doctrine\ORM\Tools\SchemaTool;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function setUp()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        if (!isset($metadatas)) {
            $metadatas = $em->getMetadataFactory()->getAllMetadata();
        }
        $schemaTool = new SchemaTool($em);
        $schemaTool->dropDatabase();
        if (!empty($metadatas)) {
            $schemaTool->createSchema($metadatas);
        }
        $this->postFixtureSetup();
    }


    public function testRegisterUser()
    {
        $this->loadFixtures(array());

        $client = static::createClient();

        $crawler = $client->request(
            'POST',
            '/app/user',
            [
                    'username' => 'test@gmail.com',
                    'password' => 'testpassword'
            ]
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);

        //var_dump($response);

        $this->assertSame(1, $response['id']);
        $this->assertSame('test@gmail.com', $response['username']);
    }

    public function testGetUser()
    {
        $this->loadFixtures(array('\AppBundle\DataFixtures\ORM\LoadUserData'));

        $client = static::createClient();

        $crawler = $client->request('GET', '/app/user/admin');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame('admin', $response['username']);
        $this->assertSame(1, $response['id']);
    }
}
