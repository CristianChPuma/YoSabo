<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Question::class);
    }


    public function findAllExcept($question) {

      $em = $this->getEntityManager();
      $query = $em->createQuery('SELECT u FROM App\Entity\Question u WHERE u.id NOT IN (:id)');
      $query->setParameter('id', $question);
      return $query->getResult();

    }

//    /**
//     * @return Question[] Returns an array of Question objects
//     */

    public function findAllE($question)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.id NOT IN (:ids)')
            ->setParameter('ids', $question)
            ->getQuery()
            ->getResult()
        ;
    }


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
