<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

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

    public function saveUser($data): ?int
    {
        $newUser = new User();

        $this->setAllUserFields($newUser, $data);

        return $newUser->getUserId();
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
        
        $this->setAllUserFields($user, $data);
    }

    public function deleteUser($userId)
    {
        $user = $this->findOneBy(['userId' => $userId]);

        if (!$user) {
            throw new \Exception(
                'No user found for id '.$userId
            );
        }

        $this->manager->remove($user);
        $this->manager->flush();
    }

    private function setAllUserFields($user, $data)
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
        $location = $data['location'];

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
        $user->setLocation($location);
        
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
