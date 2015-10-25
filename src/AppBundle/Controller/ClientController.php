<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class AccountController
 * @Route(service="bb.client.controller")
 * @package AppBundle\Controller
 *
 */
class ClientController
{
    /**
     * @var ClientManagerInterface
     */
    private $clientManager;

    public function __construct(ClientManagerInterface $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    /**
     * @Rest\Post("/app/client", name="create-client")
     * @Rest\View()
     */
    public function createAction()
    {
        $client = $this->clientManager->createClient();
        $client->setRedirectUris(['http://www.example.com']);
        $client->setAllowedGrantTypes(['token', 'password', 'authorization_code', 'client_credentials']);
        $this->clientManager->updateClient($client);

        return $client;
    }
}
