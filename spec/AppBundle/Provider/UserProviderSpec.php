<?php
namespace spec\AppBundle\Provider;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class UserProviderSpec extends ObjectBehavior
{
    function let(
        UserRepository $userRepository
    )
    {
        $this->beConstructedWith($userRepository);
    }

    function it_will_load_an_user_by_username(
        $userRepository,
        User $user
    )
    {
        $userRepository->findOneBy(['username'=>'usernameexample'])
        ->shouldBeCalled()
        ->willReturn($user);

        $this->loadUserByUsername('usernameexample')->shouldReturn($user);
    }

    function it_will_throw_an_exception_if_load_an_user_by_username_is_not_found(
        $userRepository
    )
    {
        $userRepository->findOneBy(['username'=>'usernameexample'])
            ->shouldBeCalled()
            ->willReturn(null);

        $messageException = 'Unable to find an active admin AppBundle:User object identified by "usernameexample".';

        $this->shouldThrow(new UsernameNotFoundException($messageException))
            ->duringLoadUserByUsername('usernameexample');
    }
} 