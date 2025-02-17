<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController extends AbstractController
{
    // Define la ruta para la página de administración
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        // Renderiza la plantilla 'admin/index.html.twig' y pasa el nombre del controlador como variable
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
