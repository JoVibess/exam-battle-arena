<?php

namespace App\Controller;

use App\Entity\GameMatch;
use App\Entity\MatchResult;
use App\Repository\MatchResultRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/my-matches')]
class PlayerMatchController extends AbstractController
{
    #[Route('/', name: 'player_matches')]
    public function index(): Response
    {
        return $this->render('player/matches.html.twig');
    }

    #[Route('/{id}/result/{result}', name: 'player_match_result')]
    public function submitResult(
        GameMatch $match,
        string $result,
        EntityManagerInterface $em,
        MatchResultRepository $resultRepository
    ): Response {
        $user = $this->getUser();

        if (
            $user !== $match->getPlayerOne() &&
            $user !== $match->getPlayerTwo()
        ) {
            throw $this->createAccessDeniedException();
        }

        if (!in_array($result, ['WIN', 'LOSS'])) {
            throw $this->createNotFoundException();
        }

        $existingResult = $resultRepository->findOneBy([
            'gameMatch' => $match,
            'player' => $user
        ]);

        if ($existingResult) {
            $this->addFlash('warning', 'Vous avez déjà soumis votre résultat.');
            return $this->redirectToRoute('player_matches');
        }

        $matchResult = new MatchResult();
        $matchResult->setGameMatch($match);
        $matchResult->setPlayer($user);
        $matchResult->setResult($result);

        $em->persist($matchResult);

        $opponent = $user === $match->getPlayerOne()
            ? $match->getPlayerTwo()
            : $match->getPlayerOne();

        $opponentResult = $resultRepository->findOneBy([
            'gameMatch' => $match,
            'player' => $opponent
        ]);

        if ($opponentResult) {
            if ($opponentResult->getResult() === $result) {
                $match->setStatus('validated');
            } else {
                $match->setStatus('conflict');
            }
        }

        $em->flush();

        $this->addFlash('success', 'Résultat enregistré.');

        return $this->redirectToRoute('player_matches');
    }
}
