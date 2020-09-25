<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AjoutCategorieController extends AbstractController
{
    /**
     * @Route("/ajout/categorie", name="ajout_categorie")
     */
    public function ajoutCategorie(
        Request $request, 
        EntityManagerInterface $manager,
        SluggerInterface $slugger
    ){
        // creation d'un form pour nouveau categorie
        $categorie = new Categorie();
        $form = $this->createForm(CategorieFormType::class, $categorie);

        // recuperation de la requete (pour lire les données POST)
        $form->handleRequest($request);

        // 3. Vérifier la validité du formulaire
        if($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $urlIllustration */
            /* url_Illustration configuré dans config/services.yaml */
            $urlIllustration = $form->get('url_illustration')->getData();
            
            // this condition is needed because the 'Illustration' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($urlIllustration) {
                $originalFilename = pathinfo($urlIllustration->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$urlIllustration->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $urlIllustration->move(
                        $this->getParameter('illustration_directory'),//dans config/services.taml
                        $newFilename
                    );
                } catch (FileException $e) {
                    //ajout du message d'erreur d'upload en superglobale
                    $this->addFlash('error', 'Une erreur d\'upload est survenue.');
                }

                // updates the 'urlIllustration' property to store the image file name
                // instead of its contents
                $categorie->setUrlIllustration($newFilename);
            }
            
            //persist pour stocker les donnes en BDD
            $manager->persist($categorie);
            
            $manager->flush();
            //ajout du message en superglobale
            $this->addFlash('success', 'Votre catégorie a été ajouté.');
        }
        
        return $this->render('ajout_categorie/ajoutCategorie.html.twig', [
            'controller_name' => 'AjoutCategorieController',
            'categorie_form' => $form->createView(),
        ]);
    }
}
