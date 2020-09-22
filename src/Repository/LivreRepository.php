<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

/*
    1. requete SQL pour récupérer les ids des auteurs et faire un rand dessus

    /*connextion a la BDD    

    
    
    $idAuteur = $result->fetchColumn();

    2. methode inner join pour joindre 2 tables (jointure interne) et récupérer les livres de l'auteur
    
*/


class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * @return Livre[] Returns an array of Livre objects
     */
    

    /*public function findLivresAuteur(): ?Livre
    {
        $dbConnection = $this->getEntityManager()->getConnection();
        $idAuteurRand = $dbConnection->executeQuery('SELECT id FROM auteur ORDER BY RAND() LIMIT 0, 1');
        return $this->createQueryBuilder('l')
            ->andWhere('l.auteurs = :idauteurrand')
            ->setParameter('idauteurrand', $idAuteurRand)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }*/

    public function findDerniersLivres()
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.date_ajout', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }
}
