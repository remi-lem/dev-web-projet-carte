<?php

namespace App\Repository;

use App\Entity\FavouriteStations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FavouriteStations>
 *
 * @method FavouriteStations|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavouriteStations|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavouriteStations[]    findAll()
 * @method FavouriteStations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavouriteStationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavouriteStations::class);
    }

//    /**
//     * @return FavouriteStations[] Returns an array of FavouriteStations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FavouriteStations
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
