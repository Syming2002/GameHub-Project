<?php

namespace App\Controller;

use App\Form\BoardGameType;
use App\Repository\BoardGameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BoardGameController extends AbstractController
{
    #[Route('/board-game', name: 'app_board_game')]
    public function getAllBoardGames(BoardGameRepository $boardGameRepository): Response
    {
        // get all the board games
        $boardGames = $boardGameRepository->findAll();

        return $this->render('board_game/index.html.twig', [
            'boardGames' => $boardGames,
        ]);
    }

    #[Route('/board-game/{id}/modify', name: 'boardGame_modify', requirements: ["id" => "\d+"], methods:['POST', 'GET'])]
    public function modifyBoardGame(int $id, Request $request, EntityManagerInterface $em, BoardGameRepository $boardGameRepository): Response
    {
        $boardGame = $boardGameRepository->find($id);

        if (!$boardGame) {
            throw $this->createNotFoundException("Board Game unfindable");
        }

        $form = $this->createForm(BoardGameType::class, $boardGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid(
            "modify" . $boardGame->getId(),
            $request->request->get('_token')
        )) {
            $em->flush();    
            return $this->redirectToRoute("app_board_game");
        }

        return $this->render('boardGame/modifyBoardGame.html.twig', [
            "form" => $form->createView(),
            "oeuvre" => $boardGame
        ]);
    }

    #[Route('/board-game/{id}/supprimer', name: 'boardGame_delete', requirements: ["id" => "\d+"], methods:['POST'])]
    public function supprimerOeuvre(int $id, Request $request, EntityManagerInterface $em, BoardGameRepository $oeuvreRepository): Response
    {
        $boardGame = $oeuvreRepository->find($id);

        if (!$boardGame) {
            throw $this->createNotFoundException("Oeuvre introuvable");
        }

        $form = $this->createForm(BoardGameType::class, $boardGame);
        $form->handleRequest($request);

        if ($this->isCsrfTokenValid(
            "delete" . $boardGame->getId(),
            $request->request->get('_token')
        )) {
            $em->remove($boardGame);
            $em->flush();

            $this->addFlash("success", "Oeuvre a été supprimé.");
        }

        return $this->redirectToRoute("app_board_game");
    }
}
