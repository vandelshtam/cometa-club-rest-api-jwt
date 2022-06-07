<?php

namespace App\Repository;

use App\Entity\Wallet;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use App\Exception\WalletNotExistsException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Wallet>
 *
 * @method Wallet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wallet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wallet[]    findAll()
 * @method Wallet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    public function add(Wallet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Wallet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   
    public function getExsistsByWallet(int $user_id)
    {
        $wallet = $this->findOneBy(['user_id' => $user_id]);
        if (null === $wallet) {
            throw new WalletNotExistsException();
        }

        return $wallet;
    }

    public function getExsistsByWalletId(int $wallet_id)
    {
        $wallet = $this->findOneBy(['id' => $wallet_id]);
        if (null === $wallet) {
            throw new WalletNotExistsException();
        }

        return $wallet;
    }

    /**
     * @return TransactionTable[]
     */
    public function findByAllTWallet(): array
    {
        return $this->findBy([], ['id' => Criteria::ASC]);
    }

    /**
     * @return Traversable&Countable
     */
    public function getPageBy(int $offset, int $limit)
    {
        $query = $this->_em
            ->createQuery('SELECT r FROM App\Entity\Wallet r ORDER BY r.created_at DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return new Paginator($query, false);
    }

    /**
     * @return Wallet[]
     */
    public function findByAllWallet(): array
    {
        return $this->findBy([], ['id' => Criteria::ASC]);
    }

    /**
     * @return Wallet[]
     */
    public function findByWallet(int $user_id): array
    {
        return $this->findBy([], ['user_id' => $user_id]);
    }

    // /**
    //  * @return Wallet[]
    //  */
    // public function findByWalletId(int $wallet_id): array
    // {
    //     return $this->findBy([], ['id' => $wallet_id]);
    // }



    public function getWalletTotalSum(int $id): int
    {
        return (int) $this->_em->createQuery('SELECT SUM(r.price) FROM App\Entity\Pakege r WHERE r.user_id = :id')
            ->setParameter('id', $id)
            ->getSingleScalarResult();
    }

    public function getWalletTotalUsdt(): int
    {
        return (int) $this->_em->createQuery('SELECT SUM(r.usdt) FROM App\Entity\Wallet r')
            ->getSingleScalarResult();
    }

    public function getWalletTotalBitcoin(): int
    {
        return (int) $this->_em->createQuery('SELECT SUM(r.bitcoin) FROM App\Entity\Wallet r')
            ->getSingleScalarResult();
    }

    public function getWalletTotalEtherium(): int
    {
        return (int) $this->_em->createQuery('SELECT SUM(r.etherium) FROM App\Entity\Wallet r')
            ->getSingleScalarResult();
    }

    public function getWalletTotalCometapoin(): int
    {
        return (int) $this->_em->createQuery('SELECT SUM(r.cometapoin) FROM App\Entity\Wallet r')
            ->getSingleScalarResult();
    }

   
   public function findByWalletUser($value)
   {
       $wallet = $this->createQueryBuilder('w')
           ->andWhere('w.user_id = :val')
           ->setParameter('val', $value)
           ->orderBy('w.id', 'ASC')
           ->setMaxResults(1)
           ->getQuery()
           ->getResult()
       ;

       if (null === $wallet) {
        throw new WalletNotExistsException();
        }

    return $wallet;
    }

    /**
     * @return Wallet[]
     */
   public function findByWalletId($value)
   {
       $wallet = $this->createQueryBuilder('w')
           ->andWhere('w.id = :val')
           ->setParameter('val', $value)
           ->orderBy('w.id', 'ASC')
           ->setMaxResults(1)
           ->getQuery()
           ->getResult()
       ;

       if (null === $wallet) {
        throw new WalletNotExistsException();
        }

    return $wallet;
    }


    /**
     * @return Wallet[]
     */
   public function findByWalletUserId($value)
   {
       $wallet = $this->createQueryBuilder('w')
           ->andWhere('w.user_id = :val')
           ->setParameter('val', $value)
           ->orderBy('w.id', 'ASC')
           ->setMaxResults(1)
           ->getQuery()
           ->getResult()
       ;

       if (null === $wallet) {
        throw new WalletNotExistsException();
        }

    return $wallet;
    }
   
   

//    public function findOneBySomeField($value): ?Wallet
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
