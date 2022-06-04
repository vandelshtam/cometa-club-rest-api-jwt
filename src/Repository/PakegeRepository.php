<?php

namespace App\Repository;

use Countable;
use Traversable;
use App\Entity\Pakege;
use App\Entity\SavingMail;
use App\Exception\UserNotFoundException;
use App\Exception\EmailNotFoundException;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Pakege>
 *
 * @method Pakege|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pakege|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pakege[]    findAll()
 * @method Pakege[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PakegeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pakege::class);
    }

    public function add(Pakege $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Pakege $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function countByUserId(int $id): int
    {
        return $this->count(['user_id' => $id]);
    }

    public function countById(int $id): int
    {
        return $this->count(['id' => $id]);
    }

    public function countByUserPlace(int $id): int
    {
        return $this->count(['network_id' => $id]);
    }

    public function countByType(string $type): int
    {
        return $this->count(['type' => $type]);
    }

    public function existsByName(string $name): bool
    {
        return null !== $this->findOneBy(['name' => $name]);
    }

    public function existsByPakegeUserId(int $user_id): bool
    {
        return null !== $this->findOneBy(['user_id' => $user_id]);
    }


    /**
     * @return Traversable&Countable
     */
    public function getPageBy(int $offset, int $limit)
    {
        $query = $this->_em
            ->createQuery('SELECT r FROM App\Entity\Pakege r ORDER BY r.created_at DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new Paginator($query, false);
    }

    /**
     * @return Pakege[]
     */
    public function findByAllPakege(): array
    {
        return $this->findBy([], ['id' => Criteria::ASC]);
    }

    /**
     * @return Pakege[]
     */
    public function findByPakege(int $user_id): array
    {
        return $this->findBy([], ['user_id' => $user_id]);
    }


    public function getPakegeTotalPriceSum(int $id): int
    {
        return (int) $this->_em->createQuery('SELECT SUM(r.price) FROM App\Entity\Pakege r WHERE r.user_id = :id')
            ->setParameter('id', $id)
            ->getSingleScalarResult();
    }

    public function getPakegeAllTotalPriceSum(): int
    {
        return (int) $this->_em->createQuery('SELECT SUM(r.price) FROM App\Entity\Pakege r')
            ->getSingleScalarResult();
    }




   /**
    * @return Pakege[] Returns an array of Pakege objects
    */
   public function findByExampleField($value): array
   {
       return $this->createQueryBuilder('p')
           ->andWhere('p.user_id = :val')
           ->setParameter('val', $value)
           ->orderBy('p.id', 'ASC')
           ->setMaxResults(100000)
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?Pakege
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
