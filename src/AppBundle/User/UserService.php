<?php

namespace AppBundle\User;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /** @var  UserPasswordEncoderInterface $encoder */
    private $encoder;

    /** @var EntityManagerInterface $em */
    private $em;

    /** @var UserRepository $userRepository */
    private $userRepository;

    /**
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $em
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $em,
        UserRepository $userRepository
    ) {
        $this->encoder = $encoder;
        $this->em = $em;
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $user
     */
    public function encodePassword(User $user)
    {
        $encoded = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);
    }

    public function saveUser(User $user)
    {
        $this->em->persist($user);
        $this->em->flush($user);
    }

    /**
     * @param $username
     *
     * @return null|User
     */
    public function getUser($username)
    {
        return $this->userRepository->findOneBy(['username' => $username]);
    }
} 