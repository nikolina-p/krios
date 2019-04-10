<?php

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PatientRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    public function persist(Patient $entity): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);
        $entityManager->flush();
    }

    public function saveChanges(): void
    {
        $this->getEntityManager()->flush();
    }

    public function searchPatients(string $searchTerm): array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $queryBuilder->select('p')
            ->from('App:Patient', 'p')
            ->where('p.name LIKE :searchTerm')
            ->orWhere('p.surname LIKE :searchTerm')
            ->setParameter('searchTerm', "%".$searchTerm."%");

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
