<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Factory\EntityFactory;
use AppBundle\FormHelper\ApiEntityExtractor;
use AppBundle\User\UserService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class AccountController
 * @Route(service="bb.user.controller")
 * @package AppBundle\Controller
 *
 */
class UserController
{
    /** @var TokenStorageInterface */
    private $tokenStorage;

    /** @var ApiEntityExtractor $apiEntityExtractor */
    private $apiEntityExtractor;

    /** @var  UserService */
    private $userService;

    /** @var  EntityFactory $entityFactory */
    private $entityFactory;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param ApiEntityExtractor $apiEntityExtractor
     * @param UserService $userService
     * @param EntityFactory $entityFactory
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        ApiEntityExtractor $apiEntityExtractor,
        UserService $userService,
        EntityFactory $entityFactory
    ){
        $this->tokenStorage = $tokenStorage;
        $this->apiEntityExtractor = $apiEntityExtractor;
        $this->userService = $userService;
        $this->entityFactory = $entityFactory;
    }

    /**
     *
     * @Rest\Post("/app/user", name="account_create")
     * @Rest\View(templateVar="user")
     *
     * @return User | FormInterface
     */
    public function registerAction()
    {
        $user = $this->entityFactory->createEntity(EntityFactory::ENTITY_NAME_USER);
        $form = $this->apiEntityExtractor->populateEntityFromRequest('user', $user);

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $this->userService->encodePassword($user);
        $this->userService->saveUser($user);

        return $user;
    }

    /**
     *
     * @Rest\Get("/api/user/{userName}", name="fetch_user_token")
     * @Rest\View(serializerGroups={"token"})
     *
     * @param string $userName
     * @return User
     */
    public function getUserAction($userName)
    {
        return $this->userService->getUser($userName);
    }

    /**
     *
     * @Rest\Get("/api/user", name="fetch_my_user_token")
     * @Rest\View(serializerGroups={"token"})
     *
     * @return User
     */
    public function getMyUserAction()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     *
     * @Rest\Get("/api/user/{userName}/profile", name="fetch_user_profile")
     * @Rest\View
     *
     * @param string $userName
     * @return User
     */
    public function getUserProfileAction($userName)
    {
        $user = $this->tokenStorage->getToken()->getUser();

        if ($user->getUsername()!==$userName) {
            throw new BadRequestHttpException();
        }

        return $user;
    }
}