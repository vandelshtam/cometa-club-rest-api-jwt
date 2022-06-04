<?php

namespace App\Repository;

use App\Entity\TablePakage;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<TablePakage>
 *
 * @method TablePakage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TablePakage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TablePakage[]    findAll()
 * @method TablePakage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TablePakageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TablePakage::class);
    }

    public function add(TablePakage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TablePakage $entity, bool $flush = false): void
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

    public function existsByPakageId(int $pakage_id): bool
    {
        return null !== $this->findOneBy(['id' => $pakage_id]);
    }

    /**
     * @return PakageCategory[]
     */
    public function findByAllPakage(): array
    {
        return $this->findBy([], ['name' => Criteria::ASC]);
    }

     /**
     * @return TablePakageOne[]
     */
    public function getByTokenPakageOne(int $id): array
    {
        $table_pakage_one[] = $this->find($id);
        return $table_pakage_one;
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
