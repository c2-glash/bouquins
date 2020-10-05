<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactFormController extends AbstractController
{
    /**
     * @Route("/contact", name="contact_form")
     */
    public function contactForm(
        Request $request, 
        EntityManagerInterface $manager
    )
    {   
        // creation d'un form pour nouveau contact
        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);

        // recuperation de la requete (pour lire les données POST)
        $form->handleRequest($request);

        // Vérifier la validité du formulaire
        if($form->isSubmitted() && $form->isValid()) {

            //set de la date de demande d'emprunt du livre
            $contact->setDateAjout(new \DateTime());

            //persist pour stocker les donnes en BDD
            $manager->persist($contact);
            
            $manager->flush();
            //ajout du message en superglobale
            $this->addFlash('success', 'Votre message a été transmis.');
        }

        return $this->render('contact_form/contactForm.html.twig', [
            'controller_name' => 'ContactFormController',
            'contact_form' => $form->createView(),
        ]);
    }
}
