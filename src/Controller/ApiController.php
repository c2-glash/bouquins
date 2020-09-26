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
                'loggued' => 'false',
            ];
            return new JsonResponse($utilisateurActuel);
        }
        $user = $this->getUser();
        $utilisateurActuel = [
            'loggued' => 'true',
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
            
        ];
        return new JsonResponse($utilisateurActuel);
        
    }

    /**
     * @Route("api/livres", name="api_livres")
     */
    public function TousLesLivres(LivreRepository $livreRepository)
    {
        $tousLesLivres = [];
        $livres = $livreRepository->findAll();
        
        

        foreach($livres as $livre){
            
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
                'est_disponible' => $livre->estDisponible(),
                'auteurs' => $auteursDuLivre,
                'categories' => $categoriesDuLivre,
            ];
        }

        return new JsonResponse($tousLesLivres);
    }
}