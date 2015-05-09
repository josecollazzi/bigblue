<?php

namespace spec\AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Factory\EntityFactory;
use AppBundle\FormHelper\ApiEntityExtractor;
use AppBundle\User\UserService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\FormInterface;

class UserControllerSpec extends ObjectBehavior
{
    function let(
        ApiEntityExtractor $apiEntityExtractor,
        UserService $userService,
        EntityFactory $entityFactory
    ){
        $this->beConstructedWith($apiEntityExtractor, $userService, $entityFactory);
    }

    public function it_register_an_user(
        $apiEntityExtractor,
        $userService,
        $entityFactory,
        User $user,
        FormInterface $form
    ){
        $entityFactory->createEntity(EntityFactory::ENTITY_NAME_USER)
            ->shouldBeCalled()
            ->willReturn($user);

        $apiEntityExtractor->populateEntityFromRequest('user', $user)
            ->shouldBeCalled()
            ->willReturn($form);

        $form->isValid()
            ->shouldBeCalled()
            ->willReturn(true);

        $userService->encodePassword($user)
            ->shouldBeCalled();

        $userService->saveUser($user)
            ->shouldBeCalled();

        $this->registerAction()->shouldReturn($user);
    }

    public function it_return_a_form_when_there_are_errors(
        $apiEntityExtractor,
        $entityFactory,
        User $user,
        FormInterface $form
    ){
        $entityFactory->createEntity(EntityFactory::ENTITY_NAME_USER)
            ->shouldBeCalled()
            ->willReturn($user);

        $apiEntityExtractor->populateEntityFromRequest('user', $user)
            ->shouldBeCalled()
            ->willReturn($form);

        $form->isValid()
            ->shouldBeCalled()
            ->willReturn(false);

        $this->registerAction()->shouldReturn(['form' => $form]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('AppBundle\Controller\AccountController');
    }
}
