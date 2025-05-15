<?php

namespace App\Repository;

use App\Entity\BouchonVariante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BouchonVarianteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BouchonVariante::class);
    }

    public function searchByKeyword(string $query): array
    {
        return $this->createQueryBuilder('bv')
            ->leftJoin('bv.bouchon', 'b')
            ->leftJoin('bv.antenneCouleur', 'a')
            ->leftJoin('bv.typeCorps', 't')            
            ->where('b.nom LIKE :q OR b.description LIKE :q OR a.nom LIKE :q OR t.nom LIKE :q')
            ->setParameter('q', '%' . $query . '%')
            ->getQuery()
            ->getResult();          
    }
    
}
{

    

    //    /**
    //     * @return BouchonVariante[] Returns an array of BouchonVariante objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BouchonVariante
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
