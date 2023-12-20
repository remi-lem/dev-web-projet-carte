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
        return $this->render('map/homepage.html.twig', [
            'title' => 'Accueil | GaresÀVous', //TODO passer en objet ? (methode pour la classe)
            'cssFile' => 'styles/index.css'
        ]);
    }

    #[Route('/konami')]
    public function konami():Response
    {
        return $this->render('map/konami.html.twig', [
            'title' => 'Konami | GaresÀVous', //TODO passer en objet ? (methode pour la classe)
            'cssFile' => 'konami/konami.css'
        ]);
    }

    #[Route('/userTest')]
    public function user():Response
    {
        return $this->render('map/user-account.html.twig');
    }
}