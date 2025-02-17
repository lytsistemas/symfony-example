<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    // Ruta principal de la aplicación
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        // Renderiza la plantilla 'main/index.html.twig' y pasa el nombre del controlador como parámetro
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
