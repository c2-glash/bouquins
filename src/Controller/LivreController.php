<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
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
