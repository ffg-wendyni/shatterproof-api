<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, User::class);
        $this->manager = $manager;
    }

    public function saveUser($firstName, $lastName, $email, $phone, $gender, $ethnicity, $occupation, $newsletterSub)
    {
        $newUser = new User();
        $newUser->setFirstName($firstName);
        $newUser->setLastName($lastName);
        $newUser->setEmail($email);
        $newUser->setPhone($phone);
        $newUser->setGender($gender);
        $newUser->setEthnicity($ethnicity);
        $newUser->setOccupation($occupation);
        $newUser->setNewsletterSub($newsletterSub);

        $this->manager->persist($newUser);
        $this->manager->flush();
    }

    public function updateUser($data)
    {   
        $userId = $data['userId'];
        $user = $this->findOneBy(['userId' => $userId]);

        if (!$user) {
            throw new \Exception(
                'No user found for id '.$userId
            );
        }
        
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $phone = $data['phone'];
        $gender = $data['gender'];
        $ethnicity = $data['ethnicity'];
        $occupation = $data['occupation'];
        $newsletterSub = $data['newsletterSub'];

        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setPhone($phone);
        $user->setGender($gender);
        $user->setEthnicity($ethnicity);
        $user->setOccupation($occupation);
        $user->setNewsletterSub($newsletterSub);
        
        $this->manager->persist($user);
        $this->manager->flush();
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
