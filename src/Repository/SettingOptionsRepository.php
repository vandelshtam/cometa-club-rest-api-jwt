<?php

namespace App\Repository;

use App\Entity\SettingOptions;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<SettingOptions>
 *
 * @method SettingOptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method SettingOptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method SettingOptions[]    findAll()
 * @method SettingOptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingOptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SettingOptions::class);
    }

    public function add(SettingOptions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SettingOptions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return SettingOptions[]
     */
    public function existsByAll(): array
    {
        return $this->findBy([], ['id' => Criteria::ASC]);
    }

    /**
     * @return SettingOptionsOne[]
     */
    public function getBySettingOptions(int $id): array
    {
        $setting_options[] = $this->find($id);
        return $setting_options;
    }


//    /**
//     * @return SettingOptions[] Returns an array of SettingOptions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SettingOptions
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
