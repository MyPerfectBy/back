<?php

namespace App\Repository;

use App\Entity\ProfileServices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProfileServices|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfileServices|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfileServices[]    findAll()
 * @method ProfileServices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileServicesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProfileServices::class);
    }

    // /**
    //  * @return ProfileServices[] Returns an array of ProfileServices objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProfileServices
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
