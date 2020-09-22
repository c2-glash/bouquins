<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function pageAccueil(LivreRepository $livreRepository, AuteurRepository $auteurRepository)
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'derniers_ajouts' => $livreRepository->findDerniersLivres(),
            'auteur_livres' => $auteurRepository->findAuthorBooks(3),

        ]);
    }
}
