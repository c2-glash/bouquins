<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Propriete;
use App\Form\LivreFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\File;

class AjoutLivreController extends AbstractController
{
    /**
     * @Route("/ajout/livre", name="ajout_livre")
     */
    public function ajoutLivre(
        Request $request, 
        EntityManagerInterface $manager,
        SluggerInterface $slugger
    ){
        // creation d'un form pour nouveau livre
        $livre = new Livre();
        $form = $this->createForm(LivreFormType::class, $livre);

        // recuperation de la requete (pour lire les données POST)
        $form->handleRequest($request);

        // 3. Vérifier la validité du formulaire
        if($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $urlCouverture */
            /* url_couverture configuré dans config/services.yaml */
            $urlCouverture = $form->get('url_couverture')->getData();
            
            // this condition is needed because the 'couverture' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($urlCouverture) {
                $originalFilename = pathinfo($urlCouverture->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$urlCouverture->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $urlCouverture->move(
                        $this->getParameter('couverture_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    //ajout du message d'erreur d'upload en superglobale
                    $this->addFlash('error', 'Une erreur d\'upload est survenue.');
                }

                // updates the 'urlCouverture' property to store the image file name
                // instead of its contents
                $livre->setUrlCouverture($newFilename);
            }
            //set de la date d'ajout du livre
            $livre->setDateAjout(new \DateTime());
            
            //definition de la propriete avec id user et id livre
            $propriete = new Propriete();
            $propriete->setUtilisateur($this->getUser());

            //creation de la propriété à partir de addPropriete() du livre
            $livre->addPropriete($propriete);
            
            //persist pour stocker les donnes en BDD
            //$manager->persist($propriete);
            $manager->persist($livre);
            
            $manager->flush();
            //ajout du message en superglobale
            $this->addFlash('success', 'Votre livre a été ajouté.');
        }
        
        return $this->render('ajout_livre/ajoutLivre.html.twig', [
            'controller_name' => 'AjoutLivreController',
            'livre_form' => $form->createView(),
        ]);
    }
}
