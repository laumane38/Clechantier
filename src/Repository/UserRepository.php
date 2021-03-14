<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findUser($param){

        $qb = $this->createQueryBuilder('u');

        if($param['pseudo'] !== null){
        $qb
        ->andWhere('u.pseudo LIKE :pseudo')->setParameter('pseudo', '%'.$param['pseudo'].'%');
            }
        
        if ($param['firstName'] !== null) {
            $qb
            ->andWhere('u.firstName LIKE :firstName')->setParameter('firstName', $param['firstName'].'%');
            }

        if ($param['lastName'] !== null) {
            $qb
            ->andWhere('u.lastName LIKE :lastName')->setParameter('lastName', $param['lastName'].'%');
            }

        if ($param['email'] !== null) {
            $qb
            ->andWhere('u.email LIKE :email')->setParameter('email', $param['email'].'%');
            }
        
        if ($param['companie'] !== null) {
            $qb
            ->andWhere('u.companie LIKE :companie')->setParameter('companie', $param['companie'].'%');
            }
        $qb->andWhere('u.id != :id')->setParameter('id',$param['idSeeker']);
        $qb
        ->orderBy('u.id', 'ASC');

        return $qb
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
