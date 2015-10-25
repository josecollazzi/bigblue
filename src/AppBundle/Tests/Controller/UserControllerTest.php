<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\AppTestCase;

class UserControllerTest extends AppTestCase
{
    public function testRegisterUser()
    {
        $this->loadFixtures(array());
        $client = static::createClient();

        $client->request(
            'POST',
            '/app/user',
            [
                'email' => 'test@gmail.com',
                'password' => 'testpassword'
            ]
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(1, $response['id']);
        $this->assertSame('test@gmail.com', $response['email']);
        $this->assertNotNull($response['username']);
    }

    public function testGetUser()
    {
        $this->loadFixtures(
            [
                '\AppBundle\DataFixtures\ORM\LoadUserData',
                '\AppBundle\DataFixtures\ORM\LoadClientData',
                '\AppBundle\DataFixtures\ORM\LoadAccessTokenData'
            ]
        );

        $headers = array(
            'HTTP_AUTHORIZATION' => "Bearer testToken",
            'CONTENT_TYPE' => 'application/json',
        );

        $client = static::createClient();

        $client->request('GET', '/api/user/admin', array(), array(), $headers);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);

        var_dump($response);

        $this->assertSame('admin', $response['username']);
    }
}
