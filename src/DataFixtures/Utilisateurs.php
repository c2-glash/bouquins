<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Utilisateurs extends Fixture
{   
    private $varencoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->varencoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        //Ajout du user admin
        
        $user = new Utilisateur();
        $hash = $this->varencoder->encodePassword($user,'admin');
        
        $user
            ->setEmail('admin@bouquins.io')
            ->setUsername('admin')
            ->setRoles(['ROLE_ADMIN']) #type array obligatoire
            ->setPassword($hash)
        ;
        
        $manager->persist($user);

        //Ajout des users normaux
        
        for($i = 0; $i < 20; $i++)
        {
            $user = new Utilisateur();
            $hash = $this->varencoder->encodePassword($user,'user' . $i);
            
            $user
                ->setEmail('user' . $i . '@bouquins.io')
                ->setUsername('user' . $i)
                ->setPassword($hash)
                //pas de setRole à faire car role de base défini automatiquement
            ;
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}
