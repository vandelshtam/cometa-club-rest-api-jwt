<?php

namespace App\Repository;

use App\Entity\User;
use App\Exception\UserNotFoundException;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function existsByEmail(string $email): bool
    {
        return null !== $this->findOneBy(['email' => $email]);
    }

    public function existsByPesonalCode(string $client_code): bool
    {
        return null !== $this->findOneBy(['pesonal_code' => $client_code]);
    }

    public function existsBySecretCode(string $secret_code): bool
    {
        return null !== $this->findOneBy(['secret_code' => $secret_code]);
    }

    public function getUser(int $userId): User
    {
        $user = $this->find($userId);
        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function getUserId(int $userId): User
    {
        $user = $this->findOneBy(['user_id' => $userId]);
        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function getUserByUserId(int $userId): User
    {
        $user = $this->find($userId);
        return $user;
    }

    /**
     * @return Users[]
     */
    public function findAllByUsers(): array
    {
        return $this->findBy([], ['id' => Criteria::ASC]);
    }

     /**
     * @return User[]
     */
    public function getByUser(int $userId): array
    {
        $user[] = $this->find($userId);
        if (null === $user) {
            throw new UserNotFoundException();
        }
        return $user;
    }
}
