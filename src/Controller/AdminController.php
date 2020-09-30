<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/confirmation-users", name="confirmation_users")
     */
    public function confirmationUsers(UtilisateurRepository $repository)
    {
        return $this->render('admin/confirmationUser.html.twig', [
            'liste_users' => $repository->findBy([], ['date_ajout' => 'DESC'])
        ]);
    }
}