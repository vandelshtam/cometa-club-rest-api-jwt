<?php

namespace App\Repository;

use App\Entity\PakagesCategory;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<PakagesCategory>
 *
 * @method PakagesCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PakagesCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PakagesCategory[]    findAll()
 * @method PakagesCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PakagesCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PakagesCategory::class);
    }

    public function add(PakagesCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PakagesCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function existsByName(string $name): bool
    {
        return null !== $this->findOneBy(['name' => $name]);
    }

    /**
     * @return PakagesCategory[]
     */
    public function findByAllPakages(): array
    {
        return $this->findBy([], ['name' => Criteria::ASC]);
    }

//    /**
//     * @return TablePakage[] Returns an array of TablePakage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TablePakage
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
