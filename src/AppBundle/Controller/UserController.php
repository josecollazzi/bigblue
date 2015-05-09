<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Factory\EntityFactory;
use AppBundle\FormHelper\ApiEntityExtractor;
use AppBundle\User\UserService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormInterface;

/**
 * Class AccountController
 * @Route(service="bb.user.controller")
 * @package AppBundle\Controller
 *
 */
class UserController
{
    /**
     * @var ApiEntityExtractor $apiEntityExtractor
     */
    private $apiEntityExtractor;

    /** @var  UserService */
    private $userService;

    /** @var  EntityFactory $entityFactory */
    private $entityFactory;

    /**
     * @param ApiEntityExtractor $apiEntityExtractor
     * @param UserService $userService
     * @param EntityFactory $entityFactory
     */
    public function __construct(
        ApiEntityExtractor $apiEntityExtractor,
        UserService $userService,
        EntityFactory $entityFactory
    ){
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
     * @Rest\Get("/app/user/{username}", name="fetch_user")
     * @Rest\View(templateVar="user")
     *
     * @param string $username
     * @return User
     */
    public function getUserAction($username)
    {
        $user = $this->userService->getUser($username);

        return $user;
    }
}