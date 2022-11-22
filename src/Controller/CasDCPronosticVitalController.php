<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CasDCPronosticVitalController extends AbstractController
{
    private $em;
    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    // #[Route('/cas_dc_pronostic_vital', name: 'app_cas_d_c_pronostic_vital')]
    // public function index(): Response
    // {
    //     return $this->render('cas_dc_pronostic_vital/index.html.twig', [
    //         'controller_name' => 'CasDCPronosticVitalController',
    //     ]);
    // }
    #[Route('/test_pemba', name: 'test_pemba')]
    public function test_pemba(EntityManagerInterface $em): Response
    {
        return $this->render('cas_dc_pronostic_vital/index.html.twig', [
            'controller_name' => 'CasDCPronosticVitalController',
            'em' => $em,
        ]);
    }
}
