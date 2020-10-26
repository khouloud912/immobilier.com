<?php

namespace App\Repository;

use App\Entity\Immobilier;
use App\Entity\ImmobilierSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Immobilier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Immobilier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Immobilier[]    findAll()
 * @method Immobilier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImmobilierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Immobilier::class);
    }

    /*
     * @return Query
     */


    public function findAllVisible($search){
        $query = $this->createQueryBuilder('p');

        if($search->getMaxPrice()){
            $query= $query->
            andwhere('p.price < = :maxprice')
                ->setParameter('maxprice',$search->getMaxPrice());
        }
        if($search->getMinSurface()){
            $query= $query->
            andwhere('p.surface > = :minsurface')
                ->setParameter('minsurface',$search->getMinSurface());
        }
        return $query->getQuery()->getResult();
    }

    public function findAllVisibleQuery(){
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult();

    }
        /**
      * @return Immobilier[]
         */
    public function findByLatest():array {
        return $this->createQueryBuilder('p')
            ->setMaxResults(4)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();

    }

    public function findimmobilier($userID):array {
        return $this->createQueryBuilder('p')
            ->andWhere('p.idUser = :val')
            ->setParameter('val', $userID)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;

    }

    public function findvisibleQuery():QueryBuilder{
        return $this ->createQueryBuilder('p');
    }
    public function findbyetat($etat):array{
        return $this->createQueryBuilder('p')
            ->andWhere('p.etat = :val')
            ->setParameter('val', $etat)
            ->orderBy('p.created_at', 'ASC')
            ->getQuery()
            ->getResult()
            ;


    }







    // /**
    //  * @return Immobilier[] Returns an array of Immobilier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Immobilier
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
