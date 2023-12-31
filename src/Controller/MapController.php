<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MapController Extends AbstractController
{
    #[Route('/')]
    public function homepage(): Response
    {
        session_start();
        return $this->render('map/homepage.html.twig', [
            'title' => 'Accueil | GaresÀVous',
            'cssFile' => 'styles/index.css',
            'address' => $_SESSION['address'] ?? null,
            'name' => $_SESSION['Name'] ?? "Compte"
        ]);
    }

    #[Route('/konami')]
    public function konami():Response
    {
        return $this->render('map/konami.html.twig', [
            'title' => 'Konami | GaresÀVous',
            'cssFile' => 'konami/konami.css'
        ]);
    }
}