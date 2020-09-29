<?php

namespace App\Form;

use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\Propriete;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('dateEmprunt') : ajouté automatiquement dans le controller
            //->add('dateRendu') : pas de date de rendu lors de l'emprunt
            ->add('propriete', EntityType::class, [
                'class' => Propriete::class,
                'multiple' => false,
                'expanded' => true,
                'choice_label' => fn(Propriete $propriete) => $propriete->getLivre()->getTitre() . ' - ' . $propriete->getUtilisateur()->getUsername(),// fn(Auteur $auteur) => $auteur->getPrenom() . ' ' . $auteur->getNom(),
                'by_reference' => false,
                'choices' => $options['proprietes']->filter(fn(Propriete $propriete) => $propriete->estDisponible()),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
            'proprietes' => [],
        ]);

    }
}
