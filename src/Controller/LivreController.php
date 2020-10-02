<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Propriete;
use App\Form\ProprieteFormType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
    /**
     * @Route("/livres", name="livres")
     */
    public function pageLivres(LivreRepository $livreRepository)
    {
        return $this->render('livre/livres.html.twig', [
            'liste_livres' => $livreRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/livre/{id<\d+>}", name="livre")
     */
    public function pageLivre(
    $id, 
    LivreRepository $livreRepository,
    Request $request, 
    EntityManagerInterface $manager)
    {
        //utilisateur actuel
        $utilisateur = $this->getUser();

        //liste des proprietaires du livre
        $proprietes = $livreRepository->find($id)->getPropriete();
        
        //creation tableau contenant les proprietaires du livre
        foreach($proprietes as $proprietaire){
            $proprietaires[] = $proprietaire->getUtilisateur();
        }

        //check si l'utilisateur actuel est dans la liste des proprietaires
        if(in_array($utilisateur, $proprietaires)){
            $estProprieteUserActuel = true;
        } else { $estProprieteUserActuel = false; }


        //formulaire d'ajout du livre a la propriete de l'utilisateur actuel
        // creation d'un form pour bouvelle propriete
        $propriete = new Propriete();
        $form = $this->createForm(ProprieteFormType::class, $propriete);

        // recuperation de la requete (pour lire les données POST)
        $form->handleRequest($request);

        // vérification de la validité du formulaire
        if($form->isSubmitted() && $form->isValid()) {
            //recuperation utilisateur
            $propriete->setUtilisateur($this->getUser());
            //recuperation livre
            $propriete->setLivre($livreRepository->find($id)    );
            //persist pour stocker les donnes en BDD
            $manager->persist($propriete);
            $manager->flush();
            //ajout du message en superglobale
            $this->addFlash('success', 'Vous êtes à présent propriétaire de ce livre.');
        } 


        return $this->render('livre/livre.html.twig', [
            'livre' => $livreRepository->find($id),
            'current_user' => $utilisateur,
            'propriete_user' => $estProprieteUserActuel,
            'propriete_form' => $form->createView(),
        ]);
    }
    
}