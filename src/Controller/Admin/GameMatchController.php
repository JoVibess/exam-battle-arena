<?php

namespace App\Controller\Admin;

use App\Entity\GameMatch;
use App\Repository\GameMatchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/matches')]
class GameMatchController extends AbstractController
{
    #[Route('/', name: 'admin_matches_index')]
    public function index(GameMatchRepository $repository): Response
    {
        return $this->render('admin/match/index.html.twig', [
            'matches' => $repository->findAll(),
        ]);
    }

    #[Route('/conflicts', name: 'admin_matches_conflicts')]
    public function conflicts(GameMatchRepository $repository): Response
    {
        return $this->render('admin/match/conflicts.html.twig', [
            'matches' => $repository->findBy(['status' => 'conflict']),
        ]);
    }

    #[Route('/{id}/validate', name: 'admin_match_validate')]
    public function validateMatch(
        GameMatch $match,
        EntityManagerInterface $em
    ): Response {
        $match->setStatus('validated');
        $em->flush();

        return $this->redirectToRoute('admin_matches_index');
    }

    #[Route('/{id}/delete', name: 'admin_match_delete')]
    public function deleteMatch(
        GameMatch $match,
        EntityManagerInterface $em
    ): Response {
        $em->remove($match);
        $em->flush();

        return $this->redirectToRoute('admin_matches_index');
    }
}
