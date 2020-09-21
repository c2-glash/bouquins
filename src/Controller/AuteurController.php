<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuteurController extends AbstractController
{
    /**
     * @Route("/auteur/{id<\d+>}", name="auteur")
     */
    public function pageAuteur($id, AuteurRepository $repository)
    {
        return $this->render('auteur/auteur.html.twig', [
            'id' => $id,
            'auteur' => $repository->find($id),
        ]);
    }
}
