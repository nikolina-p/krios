<?php

namespace App\Repository;

use App\Entity\XRayFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method XRayFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method XRayFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method XRayFile[]    findAll()
 * @method XRayFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class XRayFileRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, XRayFile::class);
    }

    // /**
    //  * @return XRayFile[] Returns an array of XRayFile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('x.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?XRayFile
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
