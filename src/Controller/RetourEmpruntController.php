<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Propriete;
use App\Form\RetourEmpruntFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RetourEmpruntController extends AbstractController
{
    /**
     * @Route("compte/retourner/{id<\d+>}", name="retourner")
     */
    public function retourEmprunt(
        Emprunt $emprunt,
        Request $request, 
        EntityManagerInterface $manager
    ){
        // creation d'un form pour retour emprunt
        $form = $this->createForm(RetourEmpruntFormType::class, $emprunt);

        // recuperation de la requete (pour lire les données POST)
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            //set de la date de demande de retour du livre
            $emprunt->setDateRendu(new \DateTime());

            //persist pour stocker les donnes en BDD
            $manager->persist($emprunt);
            
            $manager->flush();
            //ajout du message en superglobale
            $this->addFlash('success', 'Votre livre est à nouveau disponible au prêt.');
        }

        return $this->render('emprunt/retourEmprunt.html.twig', [
            'controller_name' => 'RetourEmpruntController',
            'retour_form' => $form->createView(),
            'emprunt' => $emprunt,
            'proprietaire' => $emprunt->getPropriete()->getUtilisateur(),
            'livre' =>  $emprunt->getPropriete()->getLivre(),
        ]);
    }
}
