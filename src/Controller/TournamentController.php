<?php

namespace App\Controller;

use App\Repository\GameMatchRepository;
use App\Repository\MatchResultRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TournamentController extends AbstractController
{
    #[Route('/', name: 'tournament_home')]

    public function index(GameMatchRepository $matchRepo, MatchResultRepository $resultRepo): Response
    {
        $matches = $matchRepo->findBy([], ['round' => 'ASC', 'id' => 'ASC']);
    
        $results = [];
    
        foreach ($matches as $match) {
            $r1 = $resultRepo->findOneBy(['gameMatch' => $match, 'player' => $match->getPlayerOne()]);
            $r2 = $resultRepo->findOneBy(['gameMatch' => $match, 'player' => $match->getPlayerTwo()]);
    
            if ($r1) {
                $results[$match->getId()][$match->getPlayerOne()->getId()] = $r1->getResult();
            }
            if ($r2) {
                $results[$match->getId()][$match->getPlayerTwo()->getId()] = $r2->getResult();
            }
        }
    
        return $this->render('tournament/index.html.twig', [
            'matches' => $matches,
            'results' => $results,
        ]);
    }
}
