<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Client;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadClientData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setAllowedGrantTypes(['token', 'password', 'authorization_code', 'client_credentials']);
        $client->setSecret('test-client-secret');
        $client->setRandomId('test-client-id');
        $client->setRedirectUris(['http://expample-test.com']);

        $manager->persist($client);
        $manager->flush();

        $this->addReference('client', $client);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}