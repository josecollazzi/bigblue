<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    /**
     * @Route("/api/articles", name="articles")
     */
    public function articlesAction()
    {
        return new JsonResponse(array('article1', 'article2', 'article3'));
    }

    public function userAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if($user) {
            return new JsonResponse(array(
                    'id' => $user->getId(),
                    'username' => $user->getUsername()
                ));
        }

        return new JsonResponse(array(
                'message' => 'User is not identified'
            )
        );
    }
}