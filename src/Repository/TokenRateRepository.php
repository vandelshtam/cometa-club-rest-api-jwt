<?php

namespace App\Repository;

use App\Entity\TokenRate;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<TokenRate>
 *
 * @method TokenRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method TokenRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method TokenRate[]    findAll()
 * @method TokenRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TokenRate::class);
    }

    public function add(TokenRate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TokenRate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
     * @return TokenRate[]
     */
    public function existsByAll(): array
    {
        return $this->findBy([], ['id' => Criteria::ASC]);
    }

    /**
     * @return TokenRateOne[]
     */
    public function getByTokenRate(int $id): array
    {
        $token_rate[] = $this->find($id);
        return $token_rate;
    }

//    /**
//     * @return TokenRate[] Returns an array of TokenRate objects
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

//    public function findOneBySomeField($value): ?TokenRate
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
