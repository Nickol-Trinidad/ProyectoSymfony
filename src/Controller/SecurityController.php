<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);

       
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

    }


    #[Route('/userinfo', name: 'api_user_info', methods: ['GET'])]
    public function getUserInfo(UserRepository $userRepository): Response
    {
        // Obtener el usuario actualmente autenticado
        $user = $this->security->getUser();

        // Verificar si el usuario está autenticado
        if (!$user) {
            return $this->json(['message' => 'Usuario no autenticado'], Response::HTTP_UNAUTHORIZED);
        }

        // Formatear la información del usuario
        $userJson = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            // Añadir otros campos necesarios
        ];

        return $this->json($userJson);
    }
}
