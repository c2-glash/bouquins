<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Utilisateur;
use App\Form\ConfirmationUserFormType;
use App\Repository\LivreRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/users", name="users")
     */
    public function users(UtilisateurRepository $repository)
    {
        return $this->render('admin/users.html.twig', [
            'liste_users' => $repository->findBy([], ['date_ajout' => 'DESC'])
        ]);
    }

    /**
     * @Route("/admin/userconfirmation/{id<\d+>}", name="user_confirmation")
     */
    public function userConfirmation(
        Utilisateur $utilisateur,
        Request $request, 
        EntityManagerInterface $manager
    ){
        // creation d'un form pour nouvel utilisateur
        $form = $this->createForm(ConfirmationUserFormType::class, $utilisateur);

        // recuperation de la requete (pour lire les données POST)
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            //set de la date de demande d'utilisateur du livre
            $utilisateur->setRoles(['ROLE_CONFIRMED']);

            //persist pour stocker les donnes en BDD
            $manager->persist($utilisateur);
            
            $manager->flush();
            //ajout du message en superglobale
            $this->addFlash('success', 'L\'utilisateur a été confirmé.');
        }

        return $this->render('admin/confirmationUser.html.twig', [
            'user_confirmation_form' => $form->createView(),
            'utilisateur' => $utilisateur,
        ]);
    }

     /**
     * @Route("/admin/testsdd", name="testsdd")
     */
    public function pageTestDd(LivreRepository $livreRepository)
    {
        return $this->render('admin/users.html.twig', [
           dump($this->getUser()->getProprietes()),
           dump($livreRepository->findAll()),
           die,
        ]);
    }


}