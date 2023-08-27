<?php

namespace App\Repository;

use App\Entity\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Parameter;

/**
 * @extends ServiceEntityRepository<Stock>
 *
 * @method Stock|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stock|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stock[]    findAll()
 * @method Stock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stock::class);
    }

    public function save(Stock $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Stock $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function update($data): bool
    {
        return $this->createQueryBuilder('s')
            ->update(Stock::class, 's')
            ->set('s.name', ':name')
            ->set('s.description', ':description')
            ->set('s.quantity', ':quantity')
            ->set('s.price', ':price')
            ->where('s.id = :id')
            ->setParameter('id', $data['id'])
            ->setParameter('price', $data['price'])
            ->setParameter('quantity', $data['quantity'])
            ->setParameter('description', $data['description'])
            ->setParameter('name', $data['name'])
            ->getQuery()
            ->execute();

    }
    //https://nicolasfz-code.medium.com/symfony-paginer-les-r%C3%A9sultats-dune-requ%C3%AAte-avec-doctrine-ebe7873197c9

    //    /**
//     * @return Stock[] Returns an array of Stock objects
//     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->execute()
        ;
    }

    //    public function findOneBySomeField($value): ?Stock
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}