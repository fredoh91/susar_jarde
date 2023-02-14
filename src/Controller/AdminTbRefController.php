<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTbRefController extends AbstractController
{
    #[Route('/admin_tbref', name: 'app_admin_tbref')]
    public function index(): Response
    {
        return $this->render('admin_tbref/liste_admin_tbref.html.twig', [
            // 'controller_name' => 'AdminTbRefController',
        ]);
    }
}
