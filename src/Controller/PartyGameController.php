<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PartyGameController extends AbstractController
{
    #[Route('/party/game', name: 'app_party_game')]
    public function index(): Response
    {
        return $this->render('party_game/index.html.twig', [
            'controller_name' => 'PartyGameController',
        ]);
    }
}
