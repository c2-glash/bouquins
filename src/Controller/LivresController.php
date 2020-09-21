<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LivresController extends AbstractController
{
    /**
     * @Route("/livres", name="livres")
     */
    public function pageLivres(LivreRepository $repository)
    {
        return $this->render('livres/livres.html.twig', [
            'liste_livres' => $repository->findLivres(),
            //dd($repository->findAll()[0]->getAuteurs())
        ]);
    }
}
