<?php

namespace App\Controller;

use App\Repository\EmpruntRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class EmpruntController extends AbstractController
{
    /**
     * @Route("/mesemprunts", name="emprunt")
     */
    public function pageEmprunts()
    {
        return $this->render('emprunt/emprunt.html.twig');
    }

    /*public function pageEmprunter($id, LivreRepository $livreRepository)
    {
        $livre = $livreRepository->find($id);
        $propriete = $livre->getPropriete();
        //dd($propriete[0], $propriete[0]->estDisponible());
        return $this->render('emprunt/confirmationEmprunt.html.twig');
    }*/
}
