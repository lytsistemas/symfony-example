<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MemberController extends AbstractController
{
    // Ruta para la página de índice de miembros
    #[Route('/member', name: 'app_member')]
    public function index(): Response
    {
        // Renderiza la plantilla de índice de miembros
        return $this->render('member/index.html.twig', [
            'controller_name' => 'MemberController',
        ]);
    }
}
