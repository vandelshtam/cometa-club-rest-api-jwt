<?php

namespace App\Repository;

use App\Entity\TransactionTable;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<TransactionTable>
 *
 * @method TransactionTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransactionTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransactionTable[]    findAll()
 * @method TransactionTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransactionTable::class);
    }

    public function add(TransactionTable $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TransactionTable $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return TransactionTable[]
     */
    public function findByAllTransactionTable(): array
    {
        return $this->findBy([], ['id' => Criteria::ASC]);
    }

   /**
    * @return TransactionTable[] Returns an array of TransactionTable objects
    */
   public function findByExampleField($value): array
   {
       return $this->createQueryBuilder('t')
           ->andWhere('t.exampleField = :val')
           ->setParameter('val', $value)
           ->orderBy('t.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?TransactionTable
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
