<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Question $entity, bool $flush = true): void
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
    public function remove(Question $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param bool $status
     * @return array
     * @throws \Doctrine\DBAL\Exception
     */
    public function getQuestionOrderByDate(bool $status): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT q.id AS id,
                   q.title AS title,
                   q.date_added AS date,
                   c.name AS category,
                   (
                       SELECT count(*)
                       FROM answer a
                       WHERE q.id = a.question_id AND
                             a.status = true
                   ) AS answerCount
            FROM question q,
                 category c
            WHERE q.category_id = c.id AND
                  q.status = :status
            ORDER BY q.date_added DESC;
            ';
        $resultSet = $connection->prepare($sql)->executeQuery(['status' => $status]);

        return $resultSet->fetchAllAssociative();
    }

    public function getQuestionById(int $id): array
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT q.id AS id,
                   q.title AS title,
                   q.text AS text,
                   q.date_added AS date,
                   c.name AS category,
                   u.name AS name
            FROM question q,
                 category c,
                 user u
            WHERE q.category_id = c.id AND
                  q.id = :id AND
                  u.id = q.user_id;
            ';
        $resultSet = $connection->prepare($sql)->executeQuery(['id' => $id]);

        return $resultSet->fetchAssociative();
    }

    // /**
    //  * @return Question[] Returns an array of Question objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Question
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
