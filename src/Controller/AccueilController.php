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
        /*recuperation de tous les auteurs */
        $auteurs = $auteurRepository->findAll();
        /*creation d'un tableau pour stocker les ids des auteurs et les indexer */
        $auteursId = array();
        /*stockage des ids des auteurs dans le tableau*/
        foreach ($auteurs as $auteur){
            $auteursId[] = $auteur->getId();
        }
        /*rand sur l'intervalle de la taille tableau*/
        $entreeTableauRand = rand(0, count($auteursId) -1 );
        /*recuperation de l'id de l'auteur*/
        $idAuteurRand = $auteursId[$entreeTableauRand];

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'derniers_ajouts' => $livreRepository->findDerniersLivres(),
            'auteur' => $auteurRepository->find($idAuteurRand),
        ]);
    }
}
