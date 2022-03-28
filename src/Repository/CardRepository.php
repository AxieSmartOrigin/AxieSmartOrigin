<?php

namespace App\Repository;

use App\Entity\AxieClass;
use App\Entity\Card;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Card::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Card $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Card $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Card[] Returns an array of Card objects
     */
    public function queryingCards($class=null, $part=null)
    {
        $qb = $this->createQueryBuilder('p');
         
        //$qb
            // ->innerJoin('App\Entity\AxieClass', 'c', 'WITH', 'c = p.class')
            // ->where('c.name like :classname')
            // ->setParameter('classname', 'Aquatic')

        if ($class) {
            $qb->innerJoin('App\Entity\AxieClass', 'c', 'WITH', 'c = p.class')
            ->where(
                $qb->expr()->like('c.name', ':classname')
            )
            ->setParameter('classname', $class);
        }

        if ($part) {
            $qb->innerJoin('App\Entity\Part', 'b', 'WITH', 'b = p.part')
            ->andWhere(
                $qb->expr()->like('b.name', ':partname')
            )
            ->setParameter('partname', $part);
        }


        $query = $qb->getQuery();
            dump($query->getResult());
            dump($query->execute());
        return $query->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Card
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllOrder()
    {
        return $this->findBy(array(), array('class' => 'ASC'));
    }
}
