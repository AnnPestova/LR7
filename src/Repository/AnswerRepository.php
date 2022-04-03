<?php

namespace App\Repository;

use App\Entity\Answer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    /**
     * @param Answer $entity
     * @param bool $flush
     * @return void
     */
    public function add(Answer $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param Answer $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Answer $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param int $id
     * @param bool $status
     * @return array
     * @throws \Doctrine\DBAL\Exception
     */
    public function getAnswersOnQuestion(int $id, bool $status): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT a.id AS id,
                   a.date_added AS date,
                   a.rightness AS rightness,
                   a.text AS text,
                   a.answer_id AS answer_id,
                   u.name AS author
            FROM answer a, 
                 user u 
            WHERE a.question_id = :id AND 
                  a.user_id = u.id AND 
                  a.status = :status
            ORDER BY a.date_added;
            ';

        $resultSet = $connection->prepare($sql)->executeQuery([
            'id' => $id,
            'status' => $status
        ]);

        return $resultSet->fetchAllAssociative();
    }

    // /**
    //  * @return Answer[] Returns an array of Answer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Answer
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
