<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\Propriete;
use App\Form\EmpruntFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AjoutEmpruntController extends AbstractController
{
    /**
     * @Route("/compte/emprunter/{id<\d+>}", name="emprunter")
     */
    public function ajoutEmprunt(
        Request $request, 
        EntityManagerInterface $manager,
        Livre $livre
    ){
        // creation d'un form pour nouvel emprunt
        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntFormType::class, $emprunt, ['proprietes' => $livre->getPropriete() ]);

        // recuperation de la requete (pour lire les données POST)
        $form->handleRequest($request);

        if($livre->estDisponible() === false){
            $this->addFlash('error', 'Le livre "'. $livre->getTitre() . '" n\'est pas disponible pour le moment.');
        } else if($form->isSubmitted() && $form->isValid()) {
            // Vérifier la validité du formulaire

            //set de la date de demande d'emprunt du livre
            $emprunt->setDateEmprunt(new \DateTime());

            //ajout de l'id user actuel en emprunteur
            $emprunt->setUtilisateur($this->getUser());

            //persist pour stocker les donnes en BDD
            $manager->persist($emprunt);
            
            $manager->flush();
            //ajout du message en superglobale
            $this->addFlash('success', 'Votre demande d\'emprunt est enregistrée. Pour récupérer le livre, vous pouvez contacter son propriétaire ');
        }

        return $this->render('emprunt/confirmationEmprunt.html.twig', [
            'controller_name' => 'AjoutEmpruntController',
            'emprunt_form' => $form->createView(),
            'livre' => $livre,
        ]);
    }
}
