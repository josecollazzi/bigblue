<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\AccessToken;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAccessTokenData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userToken = new AccessToken();
        $userToken->setClient($this->getReference('client'));
        $userToken->setUser($this->getReference('user-admin'));
        $userToken->setToken('testToken');
        $userToken->setExpiresAt(time()+100000000);

        $manager->persist($userToken);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}