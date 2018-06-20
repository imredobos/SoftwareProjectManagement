<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Service\interfaces\IUserCrudService;
use RegistrationDTO;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityController extends Controller
{
    /**
     * @var IUserCrudService
     */
    private $userService;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->userService = $container->get('app.userService');
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->userService->getUserRegistrationForm($user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword(
                    $user,
                    $user->getPlainPassword()
                );
            $user->setUserPass($password);
            $user->setUserGroup("USER");
            $this->userService->save($user);
            $token = new UsernamePasswordToken(
                $user,
                $password,
                'main',
                $user->getRoles()
            );

            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            $this->addFlash('success', 'You are now successfully registered!');
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('security/login.html.twig', [
            'registration_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
    }
}