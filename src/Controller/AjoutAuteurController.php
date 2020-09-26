<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Form\AuteurFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AjoutAuteurController extends AbstractController
{
    /**
     * @Route("/ajout/auteur", name="ajout_auteur")
     */
    public function ajoutAuteur(
        Request $request, 
        EntityManagerInterface $manager,
        SluggerInterface $slugger
    ){
        // creation d'un form pour nouveau auteur
        $auteur = new Auteur();
        $form = $this->createForm(AuteurFormType::class, $auteur);

        // recuperation de la requete (pour lire les données POST)
        $form->handleRequest($request);

        // 3. Vérifier la validité du formulaire
        if($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $urlPhoto */
            /* url_Photo configuré dans config/services.yaml */
            $urlPhoto = $form->get('url_photo')->getData();
            
            // this condition is needed because the 'Photo' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($urlPhoto) {
                $originalFilename = pathinfo($urlPhoto->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$urlPhoto->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $urlPhoto->move(
                        $this->getParameter('photo_directory'),//dans config/services.taml
                        $newFilename
                    );
                } catch (FileException $e) {
                    //ajout du message d'erreur d'upload en superglobale
                    $this->addFlash('error', 'Une erreur d\'upload est survenue.');
                }

                // updates the 'urlPhoto' property to store the image file name
                // instead of its contents
                $auteur->setUrlPhoto($newFilename);
            }
            
            //persist pour stocker les donnes en BDD
            $manager->persist($auteur);
            
            $manager->flush();
            //ajout du message en superglobale
            $this->addFlash('success', 'Votre auteur a été ajouté.');
        }
        
        return $this->render('ajout/ajoutAuteur.html.twig', [
            'controller_name' => 'AjoutAuteurController',
            'auteur_form' => $form->createView(),
        ]);
    }
}
