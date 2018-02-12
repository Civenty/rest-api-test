<?php

namespace Rest\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Rest\ApiBundle\Form\UserType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class UsersController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @ApiDoc(
     *  description="Register user",
     * )
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postRegisterAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $form = $this->createForm(UserType::class, $user, [
            'csrf_protection' => false,
        ]);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            $response = [
                'errors' => (string) $form->getErrors(true, false),
            ];

            $view = $this->view($response, 200);

            return $this->handleView($view);
        }

        $user->setUsername($form->getData()->getEmail());
        $user->setEnabled(true);
        $tokenGenerator = $this->get('fos_user.util.token_generator');
        $user->setConfirmationToken($tokenGenerator->generateToken());

        $userManager->updateUser($user);
        $userManager->reloadUser($user);

        $cachedUsers = $this->get('cache.app')->getItem('users');

        $cachedUsers->set([$user->getConfirmationToken() => $user->getId()]);
        $this->get('cache.app')->save($cachedUsers);

        $view = $this->view(['token' => $user->getConfirmationToken()], 200);

        return $this->handleView($view);
    }
}
