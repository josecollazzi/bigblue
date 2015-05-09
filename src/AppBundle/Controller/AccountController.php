<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class AccountController extends Controller
{
    /**
     * @Route("/app/registration", name="account_create")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $form = $this->createForm(new UserType(), $user);

        $form->submit($request->request->all());
        $form->handleRequest($request);

        $valid = $form->isValid();

        if ($valid) {
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());

            //encode password
            $user->setPassword($encoded);

            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush($user);

            return new JsonResponse(
                [
                    'username' => $user->getUsername(),
                    'role' => $user->getRoles()
                ]
            );

        } else {
            $validator = $this->get('validator');
            $errors = $validator->validate($user)->getIterator();
            $errorReturn =[];
            foreach($errors as $error){
                $errorReturn[]= [
                    $error->getPropertyPath() => $error->getMessage()
                ];
            }

            foreach($form->getErrors() as $error) {
                $errorReturn[]= [
                    'form' => $error->getMessage()
                ];
            }

            return new JsonResponse(['user' => $errorReturn], 400);
        }
    }
}