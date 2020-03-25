<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Location::class);
        $this->manager = $manager;
    }

    public function saveLocation($data)
    {
        $street1 = $data['street1'];
        $street2 = $data['street2'];
        $state = $data['state'];
        $country = $data['country'];
        $zipcode = $data['zipcode'];
        
        $newLocation = new Location();
        $newLocation->setStringField('street1', $street1);
        $newLocation->setStringField('street2', $street2);
        $newLocation->setStringField('state', $state);
        $newLocation->setStringField('country', $country);
        $newLocation->setStringField('zipcode', $zipcode);

        $this->manager->persist($newLocation);
        $this->manager->flush();
    }

    public function updateLocation($data)
    {   
        $locationId = $data['locationId'];
        $location = $this->findOneBy(['locationId' => $locationId]);

        if (!$location) {
            throw new \Exception(
                'No location found for id '.$locationId
            );
        }
        
        $street1 = $data['street1'];
        $street2 = $data['street2'];
        $state = $data['state'];
        $country = $data['country'];
        $zipcode = $data['zipcode'];

        $location->setStringField('street1', $street1);
        $location->setStringField('street2', $street2);
        $location->setStringField('state', $state);
        $location->setStringField('country', $country);
        $location->setStringField('zipcode', $zipcode);
        
        $this->manager->persist($location);
        $this->manager->flush();
    }

    // /**
    //  * @return Location[] Returns an array of Location objects
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
    public function findOneBySomeField($value): ?Location
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
