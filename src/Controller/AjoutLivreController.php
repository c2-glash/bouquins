<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Propriete;
use App\Form\LivreFormType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Image;

class AjoutLivreController extends AbstractController
{
    /**
     * @Route("/ajout/livre", name="ajout_livre")
     */
    public function ajoutLivre(
        Request $request, 
        EntityManagerInterface $manager,
        SluggerInterface $slugger,
        LivreRepository $livreRepository
    ){
        // creation d'un form pour nouveau livre
        $livre = new Livre();
        $form = $this->createForm(LivreFormType::class, $livre);

        // recuperation des livres
        $listeLivres = $livreRepository->findAll();
        
        // recuperation de la requete (pour lire les données POST)
        $form->handleRequest($request);

        // recuperation du titre et auteur entrés dans le form
        $titreRenseigne = strtolower($form->get('titre')->getData());

        //definition variable bool pour livre deja existant et var de recuperation de l'id
        $livreExiste = false;
        $livreId = new Integer;

        foreach($listeLivres as $livreAVerifier){
            //si le titre existe déja pour un des livres
            if(strtolower($livreAVerifier->getTitre()) == $titreRenseigne){
                //on recup l'id
                $livreId = $livreAVerifier->getId();
                //on met le bool a true
                $livreExiste = true;
                //et on coupe la boucle for
                break;
            }
        }
        
        //si listeTitres contient le titre renseigné : check l'auteur
        if($livreExiste === true){
            //ajout du message d'erreur en superglobale et on ne traite pas le form
            $this->addFlash('error', 'Ce livre existe déjà sur ce site à l\'adresse suivante : /livre/' . $livreId . ' . Vous pouvez aller sur sa page et vous déclarer propriétaire.');

        } else {

            // vérification de la validité du formulaire
            if($form->isSubmitted()){
                if($form->isValid()){

                    /** @var UploadedFile $urlCouverture */
                    /* url_couverture configuré dans config/services.yaml */
                    $urlCouverture = $form->get('url_couverture')->getData();

                    //recuperation de l'url entrée dans le champ
                    $urlExterneCouverture = $form->get('url_externe_couverture')->getData();

                    //si j'ai une couverture uploadee par l'utilisateur
                    if ($urlCouverture) {
                        $originalFilename = pathinfo($urlCouverture->getClientOriginalName(), PATHINFO_FILENAME);
                        // this is needed to safely include the file name as part of the URL
                        $safeFilename = $slugger->slug($originalFilename);
                        $newFilename = $safeFilename.'-'.uniqid().'.'.$urlCouverture->guessExtension();

                        // Stockage du fichier dans le dossier défini dans config/services.yaml
                        try {
                            $urlCouverture->move(
                                $this->getParameter('couverture_directory'),//
                            );
                        } catch (FileException $e) {
                            //ajout du message d'erreur d'upload en superglobale
                            $this->addFlash('error', 'Une erreur d\'upload est survenue.');
                        }

                        // updates the 'urlCouverture' property to store the image file name
                        // instead of its contents
                        $livre->setUrlCouverture($newFilename);
                    } // sinon, si j'ai une URL de couverture externe
                    elseif ($urlExterneCouverture) {
                        //recuperation du nom du fichier à partir de l'url et supp extension
                        //https://www.php.net/manual/en/function.pathinfo.php
                        
                        //verification fichier image
                        //https://www.php.net/manual/en/function.get-headers.php
                        $couvertureExtension = pathinfo($urlExterneCouverture)['extension'];
                        if(
                            $couvertureExtension === 'jpg' ||
                            $couvertureExtension === 'jpeg' ||
                            $couvertureExtension === 'png'
                        ){
                            //suppression de l'extension d'origine du fichier
                            $nomCouvertureExterne = pathinfo($urlExterneCouverture);
                            
                            //Passage du nom de fichier par slug pour la sécurité
                            $nomCouvertureExterneSecurise = $slugger->slug($nomCouvertureExterne['filename']);
                            
                            //Ajout de l'extention .png
                            $nouveaunomCouvertureExterne = $nomCouvertureExterneSecurise.'-'.uniqid().'.png';

                            //recuperation de l'image depuis l'URL passée
                            $nouvelleCouverture = '../assets/img/' . $nouveaunomCouvertureExterne;

                            try {
                            //PHP copy() pour mettre la nouvelle image dans le dossier assets : https://www.php.net/manual/fr/function.copy.php
                                copy($urlExterneCouverture, $nouvelleCouverture);
                                if(filesize($nouvelleCouverture) > 500000){
                                    unlink($nouvelleCouverture);
                                    $this->addFlash('error', 'L\'image est trop lourde, l\'upload à échoué, mais le livre a bien été créé.');
                                
                                }
                            } catch (FileException $e) {
                                //ajout du message d'erreur d'upload en superglobale
                                $this->addFlash('error', 'Une erreur d\'upload est survenue.');
                            }

                            //Stockage du nom du fichier (et pas du contenu du fichier)
                            $livre->setUrlCouverture($nouveaunomCouvertureExterne);
                        }

                        
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
                } else {
                    $this->addFlash('error', 'Erreur lors de l\'ajout du livre, veuillez ré-essayer. Si l\'erreur persiste, veuillez contacter Bouquins.');
                }
            }
        }
        
        return $this->render('ajout/ajoutLivre.html.twig', [
            'controller_name' => 'AjoutLivreController',
            'livre_form' => $form->createView(),
        ]);
    }
}
