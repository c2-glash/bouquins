<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('titre', TextType::class, [
                'attr' => ['placeholder' => 'Le titre du livre'],
            ])
            ->add('isbn', IntegerType::class, [
                'attr' => ['placeholder' => 'L\'ISNB du livre (son code barre, 13 chiffres)'],
                'label' => 'ISBN',
                'required' => false,
            ])
            ->add('description', TextareaType::class,[
                'required' => false,
                'attr' => ['placeholder' => 'Une description c\'est mieux !'],
            ])
            ->add('url_couverture', FileType::class, [
                'label' => 'Couverture (image .jpg / .png)',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '600k',
                        'maxSizeMessage' => 'La taille de fichier est limitée à 600Ko, veuillez en upload un plus léger.',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Veuillez sélectionner un fichier de type .png, jpg ou jepg.',
                    ])
                ],
            ])
            ->add('url_externe_couverture', TextType::class, [
                'label' => 'Upload d\'une couverture via URL (image .jpg / .png)',
                'attr' => ['placeholder' => 'https://uneurlversuneimage.jpg'],
                'mapped' => false,
                'required' => false,
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
