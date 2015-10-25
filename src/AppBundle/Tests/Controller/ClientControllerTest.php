<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\AppTestCase;

class ClientControllerTest extends AppTestCase
{
    public function testCreateClient()
    {
        $this->loadFixtures(array());

        $client = static::createClient();
        $client->request('POST', '/app/client');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertNotEmpty($content['client_id']);
        $this->assertNotEmpty($content['client_secret']);
        var_dump($content);

        // todo the serializer should not expose random_id
        //$this->assertArrayNotHasKey('random_id', $content);

    }
}
