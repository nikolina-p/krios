<?php

namespace App\Repository;

use App\Entity\XRayFile;
use App\Exception\EntityNotDeletedException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

class XRayFileRepository extends ServiceEntityRepository
{
    use RepositoryTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, XRayFile::class);
    }

    public function delete(XRayFile $file)
    {
        try {
            $entityManager = $this->getEntityManager();
            $entityManager->remove($file);
            $entityManager->flush();
        } catch (ORMException $e) {
            throw new EntityNotDeletedException("Error: Entity could not be deleted.");
        }
    }
}
