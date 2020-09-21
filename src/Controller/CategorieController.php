<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie/{id<\d+>}", name="categorie")
     */
    public function pageCategorie($id, CategorieRepository $repository)
    {
        return $this->render('categorie/categorie.html.twig', [
            'id' => $id,
            'categorie' => $repository->find($id),

            //dd($repository->find($id))
        ]);
    }
    
}
