<?php 

namespace App\Controller;

use App\Repository\LivreRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{   
    /**
     * @Route("api/user", name="api_user")
     */
    public function checkUser(UtilisateurRepository $utilisateurRepository)
    {
        $user = '';
        if($this->getUser() === null){
            $utilisateurActuel = [
                'loggue' => false,
            ];
            return new JsonResponse($utilisateurActuel);
        }
        $user = $this->getUser();
        $utilisateurActuel = [
            'loggue' => true,
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ];
        return new JsonResponse($utilisateurActuel);
        
    }

    /**
     * @Route("api/livres", name="api_livres")
     */
    public function TousLesLivres(LivreRepository $livreRepository, UtilisateurRepository $utilisateurRepository)
    {
        $tousLesLivres = [];
        $livres = $livreRepository->findAll();

        $utilisateurloggue = true;
        if($this->getUser() === null){
            $utilisateurloggue = false;
        }
       
        

        foreach($livres as $livre){

            $livreDisponible = $livre->estDisponible();
            $livreEmpruntable = false;
            if($livreDisponible === true && $utilisateurloggue === true){
                $livreEmpruntable = true;
            }
            /*recuperation des auteurs du livre*/
            $auteurs = $livre->getAuteurs();
            $auteursDuLivre = [];
            
            foreach($auteurs as $auteur){
                $auteursDuLivre[] = [
                    'id' => $auteur->getId(),
                    'prenom' => $auteur->getPrenom(),
                    'nom' => $auteur->getNom(),
                    'description' => $auteur->getDescription(),
                    'url_photo' => $auteur->getUrlPhoto(),
                ];
            }
            
            /*recuperation des categories du livre*/
            $categories = $livre->getCategories();
            $categoriesDuLivre = [];
            
            foreach($categories as $categorie){
                $categoriesDuLivre[] = [
                    'id' => $categorie->getId(),
                    'nom' => $categorie->getNom(),
                    'description' => $categorie->getDescription(),
                    'url_illustration' => $categorie->getUrlIllustration(),
                ];
            }

            /*stockage des données livres dans un tableau*/
            $tousLesLivres[] = [
                'id' => $livre->getId(),
                'titre' => $livre->getTitre(),
                'description' => $livre->getDescription(),
                'url_couverture' => $livre->getUrlCouverture(),
                'date_ajout' => date_format($livre->getDateAjout(), 'd/m/Y'),
                'auteurs' => $auteursDuLivre,
                'categories' => $categoriesDuLivre,
                'utilisateur_loggue' => $utilisateurloggue,
                'est_disponible' => $livre->estDisponible(),
                'est_empruntable' => $livreEmpruntable,
            ];
        }

        return new JsonResponse($tousLesLivres);
    }
}