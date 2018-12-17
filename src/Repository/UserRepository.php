<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param User $user
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function persists(User $user)
    {
        $this->_em->persist($user);
        $this->save();
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save()
    {
        $this->_em->flush();
    }

    /**
     * @param $login
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findUserByUsernameOrEmail($login)
    {
        return $this
            ->createQueryBuilder('u')
            ->where('u.username = :login OR u.email = :login')
            ->setParameter('login', $login)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}