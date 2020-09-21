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
     * @Route("/auteur/{id<\d+>}", name="auteur")
     */
    public function pageAuteur(Auteur $auteur)
    {
        return $this->render('auteur/auteur.html.twig', [
            'auteur' => $auteur,
        ]);
    }
}
