<?php
namespace spec\AppBundle\FormHelper;

use AppBundle\Entity\User;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;

class ApiEntityExtractorSpec extends ObjectBehavior
{
    function let(
        FormFactoryInterface $formFactory,
        RequestStack $requestStack
    ){
        $this->beConstructedWith($formFactory, $requestStack);
    }

    public function it_will_populate_the_entity_and_return_a_form(
        $formFactory,
        $requestStack,
        FormInterface $form,
        User $user,
        Request $request
    ){
        $formFactory->createNamed('userNameForm', 'formServiceUser', $user)
            ->shouldBeCalled()
            ->willReturn($form);

        $requestStack->getCurrentRequest()
            ->shouldBeCalled()
            ->willReturn($request);

        $form->handleRequest($request)
            ->shouldBeCalled();

        $form->isSubmitted()
            ->shouldBeCalled()
            ->willReturn(true);

        $this->populateEntityFromRequest('formServiceUser', $user, 'userNameForm')
            ->shouldReturn($form);
    }

    public function it_will_force_submit_an_empty_form_if_is_not_submitted(
        $formFactory,
        $requestStack,
        FormInterface $form,
        User $user,
        Request $request
    ){
        $formFactory->createNamed('userNameForm', 'formServiceUser', $user)
            ->shouldBeCalled()
            ->willReturn($form);

        $requestStack->getCurrentRequest()
            ->shouldBeCalled()
            ->willReturn($request);

        $form->handleRequest($request)
            ->shouldBeCalled();

        $form->submit([])
            ->shouldBeCalled();

        $form->isSubmitted()
            ->shouldBeCalled()
            ->willReturn(false);



        $this->populateEntityFromRequest('formServiceUser', $user, 'userNameForm')
            ->shouldReturn($form);
    }
} 