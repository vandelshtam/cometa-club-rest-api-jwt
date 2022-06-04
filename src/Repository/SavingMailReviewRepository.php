<?php

namespace App\Repository;

use Countable;
use Traversable;
use App\Entity\SavingMail;
use App\Exception\UserNotFoundException;
use App\Exception\EmailNotFoundException;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method SavingMailReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method SavingMailReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method SavingMailReview[]    findAll()
 * @method SavingMailReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SavingMailReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SavingMail::class);
    }

    public function countByUserId(int $id): int
    {
        return $this->count(['user_id' => $id]);
    }

    public function countByToMail(string $to_mail): int
    {
        return $this->count(['to_mail' => $to_mail]);
    }

    public function countByCategory(string $category): int
    {
        return $this->count(['to_mail' => $category]);
    }

    // public function getEmail(string $email)
    // {
    //     //$email = $this->find(['to_mail' => $email]);
    //    $email = $this->createQueryBuilder('r')
    //        ->andWhere('r.to_mail = :val')
    //        ->setParameter('val', $email)
    //        ->orderBy('r.id', 'ASC')
    //        ->setMaxResults(1)
    //        ->getQuery()
    //        ->getResult()
    //    ;
    //     if ($email == false) {
    //         throw new EmailNotFoundException();
    //     }

    //     return $email;
    // }

    public function existsByEmail(string $to_mail): bool
    {
        return null !== $this->findOneBy(['to_mail' => $to_mail]);
    }

    public function existsByUserId(string $id): bool
    {
        return null !== $this->findOneBy(['user_id' => $id]);
    }

    public function existsByCategoryTable(string $category): bool
    {
        return null !== $this->findOneBy(['category' => $category]);
    }

    public function existsByDate($date_time): bool
    {
        return null !== $this->findOneBy(['created_at' => $date_time]);
    }

    // public function getUserId($value)
    // {
    //     $user = $this->createQueryBuilder('r')
    //        ->andWhere('r.user_id = :val')
    //        ->setParameter('val', $value)
    //        ->orderBy('r.id', 'ASC')
    //        ->setMaxResults(1)
    //        ->getQuery()
    //        ->getResult()
    //    ;
    //     if ($user == false) {
    //         throw new UserNotFoundException();
    //     }

    //     return $user;
    // }


    /**
     * @return Traversable&Countable
     */
    public function getPageByUserId(int $id, int $offset, int $limit)
    {
        $query = $this->_em
            ->createQuery('SELECT r FROM App\Entity\SavingMail r WHERE r.user_id = :id ORDER BY r.created_at DESC')
            ->setParameter('id', $id)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new Paginator($query, false);
    }

    /**
     * @return Traversable&Countable
     */
    public function getPageByToMail(string $to_mail, int $offset, int $limit)
    {
        $query = $this->_em
            ->createQuery('SELECT r FROM App\Entity\SavingMail r WHERE r.to_mail = :to_mail ORDER BY r.created_at DESC')
            ->setParameter('to_mail', $to_mail)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new Paginator($query, false);
    }

    /**
     * @return Traversable&Countable
     */
    public function getPageByCategory(string $category, int $offset, int $limit)
    {
        $query = $this->_em
            ->createQuery('SELECT r FROM App\Entity\SavingMail r WHERE r.category = :val ORDER BY r.created_at DESC')
            ->setParameter('val', $category)
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
            ->createQuery('SELECT r FROM App\Entity\SavingMail r WHERE r.created_at >= :created_at ORDER BY r.created_at DESC')
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
            ->createQuery('SELECT r FROM App\Entity\SavingMail r ORDER BY r.created_at DESC')
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

   /**
     * @return SavingMail[]
     */
    public function findByAllSavingMail(): array
    {
        return $this->findBy([], ['id' => Criteria::ASC]);
    }
}
