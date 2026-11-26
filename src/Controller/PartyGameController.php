<?php

namespace App\Controller;

use App\Repository\PartyGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PartyGameController extends AbstractController
{
    #[Route('/party_game', name: 'app_party_game')]
    public function showPartyGame(PartyGameRepository $partyGameRepository): Response
    {
        // get all the party games
        $partyGames = $partyGameRepository->findAll();

        return $this->render('party_game/index.html.twig', [
            'partyGames' => $partyGames,
        ]);
    }
}
