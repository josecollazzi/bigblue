<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    /**
     * @Route("/app/example-client", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/app/create", name="create-client")
     */
    public function createAction()
    {
        $urlRedirection = 'http://www.example.com';
        $clientManager = $this->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris([$urlRedirection]);
        $client->setAllowedGrantTypes(['token', 'password', 'authorization_code', 'client_credentials']);
        $clientManager->updateClient($client);

        $clientData = [
            'client_id'     => $client->getPublicId(),
            'client_secret' => $client->getSecret(),
            'redirect_uri'  => $urlRedirection,
            'response_type' => 'code'
        ];

        /*
        return $this->redirect($this->generateUrl('fos_oauth_server_authorize', array(
                    'client_id'     => $client->getPublicId(),
                    'redirect_uri'  => 'http://www.example.com',
                    'response_type' => 'code'
                )));
        *
        */

        $headers = array(
            'Content-Type' => 'application/json'
        );

        return new Response(json_encode($clientData), 200, $headers);
    }
}
