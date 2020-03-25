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

    public function saveUser($data)
    {

        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $phone = $data['phone'];
        $gender = $data['gender'];
        $dob = $data['dob'];
        $ethnicity = $data['ethnicity'];
        $occupation = $data['occupation'];
        $organization = $data['organization'];
        $newsletterSub = $data['newsletterSub'];
        $textAlertSub = $data['textAlertSub'];
        $shareOnMedia = $data['shareOnMedia'];
        $pledged = $data['pledged'];
        $customPledgeLink = $data['customPledgeLink'];

        $newUser = new User();
        $newUser->setStringField('firstName', $firstName);
        $newUser->setStringField('lastName', $lastName);
        $newUser->setStringField('email', $email);
        $newUser->setStringField('phone', $phone);
        $newUser->setStringField('gender', $gender);
        $newUser->setDateField('dob', $dob);
        $newUser->setStringField('ethnicity', $ethnicity);
        $newUser->setStringField('occupation', $occupation);
        $newUser->setStringField('organization', $organization);
        $newUser->setBooleanField('newsletterSub', $newsletterSub);
        $newUser->setBooleanField('textAlertSub', $textAlertSub);
        $newUser->setBooleanField('shareOnMedia', $shareOnMedia);
        $newUser->setBooleanField('pledged', $pledged);
        $newUser->setStringField('customPledgeLink', $customPledgeLink);

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
        $dob = $data['dob'];
        $ethnicity = $data['ethnicity'];
        $occupation = $data['occupation'];
        $organization = $data['organization'];
        $newsletterSub = $data['newsletterSub'];
        $textAlertSub = $data['textAlertSub'];
        $shareOnMedia = $data['shareOnMedia'];
        $pledged = $data['pledged'];
        $customPledgeLink = $data['customPledgeLink'];

        $user->setStringField('firstName', $firstName);
        $user->setStringField('lastName', $lastName);
        $user->setStringField('email', $email);
        $user->setStringField('phone', $phone);
        $user->setStringField('gender', $gender);
        $user->setDateField('dob', $dob);
        $user->setStringField('ethnicity', $ethnicity);
        $user->setStringField('occupation', $occupation);
        $user->setStringField('organization', $organization);
        $user->setBooleanField('newsletterSub', $newsletterSub);
        $user->setBooleanField('textAlertSub', $textAlertSub);
        $user->setBooleanField('shareOnMedia', $shareOnMedia);
        $user->setBooleanField('pledged', $pledged);
        $user->setStringField('customPledgeLink', $customPledgeLink);
        
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
