<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuteurController extends AbstractController
{
    /**
     * @Route("/auteurs", name="auteurs")
     */
    public function pageAuteurs(AuteurRepository $repository)
    {
        return $this->render('auteur/auteurs.html.twig', [
            'liste_auteurs' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/auteur/{id<\d+>}", name="auteur")
     */
    public function pageAuteur(Auteur $auteur)
    {
        return $this->render('auteur/auteur.html.twig', [
            'auteur' => $auteur,
        ]);
    }
}