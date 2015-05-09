<?php

namespace spec\AppBundle\Factory;

use AppBundle\Factory\EntityFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EntityFactorySpec extends ObjectBehavior
{
    function it_will_return_an_user()
    {
        $this->createEntity(EntityFactory::ENTITY_NAME_USER)
            ->shouldReturnAnInstanceOf('AppBundle\Entity\User');
    }

    function it_will_throw_exception_if_entity_not_found()
    {
        $this->shouldThrow('Exception')->duringCreateEntity('not_valid');
    }


    function it_is_initializable()
    {
        $this->shouldHaveType('AppBundle\Factory\EntityFactory');
    }
}
