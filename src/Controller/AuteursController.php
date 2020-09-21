<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuteursController extends AbstractController
{
    /**
     * @Route("/auteurs", name="auteurs")
     */
    public function pageAuteurs(AuteurRepository $repository)
    {
        return $this->render('auteurs/auteurs.html.twig', [
            'liste_auteurs' => $repository->findAll(),
        ]);
    }
}
