<?php

namespace App\Repository;

use Countable;
use Traversable;
use App\Entity\Review;
use App\Entity\TransactionTable;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method TransactionTableReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransactionTableReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransactionTableReview[]    findAll()
 * @method TransactionTableReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionTableReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransactionTable::class);
    }

    public function countByUserId(int $id): int
    {
        return $this->count(['user_id' => $id]);
    }

    public function getBookTotalRatingSum(int $id): int
    {
        return (int) $this->_em->createQuery('SELECT SUM(r.rating) FROM App\Entity\Review r WHERE r.book = :id')
            ->setParameter('id', $id)
            ->getSingleScalarResult();
    }

    /**
     * @return Traversable&Countable
     */
    public function getPageByUserId(int $id, int $offset, int $limit)
    {
        $query = $this->_em
            ->createQuery('SELECT r FROM App\Entity\TransactionTable r WHERE r.user_id = :id ORDER BY r.created_at DESC')
            ->setParameter('id', $id)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new Paginator($query, false);
    }

    /**
     * @return Traversable&Countable
     */
    public function getPageByDate($date_time, int $offset, int $limit)
    {
        $query = $this->_em
            ->createQuery('SELECT r FROM App\Entity\TransactionTable r WHERE r.created_at >= :created_at ORDER BY r.created_at DESC')
            ->setParameter('created_at', $date_time)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new Paginator($query, false);
    }

    /**
     * @return Traversable&Countable
     */
    public function getPageByDateTwo($date_time, int $offset, int $limit)
    {
        $query = $this->createQueryBuilder('r')
            ->andWhere('r.created_at >= :created_at')
            ->setParameter('created_at', $date_time)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return new Paginator($query, false);
    }


    /**
     * @return Traversable&Countable
     */
    public function getPageBy(int $offset, int $limit)
    {
        $query = $this->_em
            ->createQuery('SELECT r FROM App\Entity\TransactionTable r ORDER BY r.created_at DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new Paginator($query, false);
    }

    /**
    * @return TransactionTableReview[] Returns an array of TransactionTable objects
    */
   public function findByExampleField($value): array
   {
       return $this->createQueryBuilder('r')
           ->andWhere('r.created_at >= :val')
           ->setParameter('val', $value)
           ->orderBy('r.id', 'ASC')
           ->setMaxResults(100000)
           ->getQuery()
           ->getResult()
       ;
   }
}
