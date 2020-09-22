<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class LivreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //https://symfony.com/doc/current/reference/forms/types.html

        $builder
            ->add('titre', TextType::class)
            ->add('description', TextareaType::class)
            ->add('url_couverture', FileType::class, [
                'label' => 'Couverture (image .jpg / .png)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '600k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner un fichier de type .png, jpg ou jepg.',
                    ])
                ],
            ])
            ->add('auteurs', EntityType::class, [
                'class' => Auteur::class,
                'multiple' => true,
                'expanded' => false,
                'choice_label' => fn(Auteur $auteur) => $auteur->getPrenom() . ' ' . $auteur->getNom(),
                'by_reference' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'multiple' => true,
                'expanded' => false,
                'choice_label' => 'nom',
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
