<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
    /**
     * @Route("/livres", name="livres")
     */
    public function pageLivres(LivreRepository $repository)
    {
        return $this->render('livre/livres.html.twig', [
            'liste_livres' => $repository->findAll(),
        ]);
    }
    
    /**
     * @Route("/livre/{id<\d+>}", name="livre")
     */
    public function pageLivre($id, LivreRepository $repository)
    {
        return $this->render('livre/livre.html.twig', [
            'id' => $id,
            'livre' => $repository->find($id),
        ]);
    }
}