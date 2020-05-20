<?php

namespace App\Repository;

use App\Entity\CustomPledge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method CustomPledge|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomPledge|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomPledge[]    findAll()
 * @method CustomPledge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomPledgeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, CustomPledge::class);
        $this->manager = $manager;
    }

    public function saveCustomPledge($firstName, $lastName, $body)
        {
            $newCustomPledge = new CustomPledge();

            $newCustomPledge
                ->setFirstName($firstName)
                ->setLastName($lastName)
                ->setLikeCount(0)
                ->setBody($body)
                ->setApproved(false);

            $this->manager->persist($newCustomPledge);
            $this->manager->flush();
            return $newCustomPledge;
        }

    public function updateCustomPledge(CustomPledge $customPledge): CustomPledge
    {
        $this->manager->persist($customPledge);
        $this->manager->flush();

        return $customPledge;
    }

    public function removeCustomPledge(CustomPledge $customPledge)
    {
        $this->manager->remove($customPledge);
        $this->manager->flush();
    }

    // /**
    //  * @return CustomPledge[] Returns an array of CustomPledge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CustomPledge
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
