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

    public function saveUser($data): ?int
    {
        // email is unique
        $email = $data['email'];
        $user = $this->findOneBy(['email' => $email]);

        if ($user) {
            throw new \Exception(
                'User with id '.$user->getUserId().' already exists for email '.$email. ' !'
            );
        }

        $newUser = new User();
        $newUser->setUserPledge($data['userPledge']);

        $this->setAllUserFields($newUser, $data);

        return $newUser->getUserId();
    }

    public function updateUser($data)
    {   
        $userId = $data['userId'];
        $user = $this->findOneBy(['userId' => $userId]);

        if (!$user) {
            throw new \Exception(
                'No user found for id '.$userId.' !'
            );
        }
        
        // email is unique
        $email = $data['email'];
        $userWithEmail = $this->findOneBy(['email' => $email]);

        if ($user->getUserId() != $userWithEmail->getUserId()) {
            throw new \Exception(
                'User with id '.$userWithEmail->getUserId().' already exists for email '.$email. ' !'
            );
        }

        $this->setAllUserFields($user, $data);
    }

    public function deleteUser($userId)
    {
        $user = $this->findOneBy(['userId' => $userId]);

        if (!$user) {
            throw new \Exception(
                'No user found for id '.$userId.' !'
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
        $zipcode = $data['zipcode'];
        $organization = $data['organization'];
        $newsletterSub = $data['newsletterSub'];
        $pledged = $data['pledged'];

        $user->setStringField('firstName', $firstName);
        $user->setStringField('lastName', $lastName);
        $user->setStringField('email', $email);
        $user->setStringField('zipcode', $zipcode);
        $user->setStringField('organization', $organization);
        $user->setBooleanField('newsletterSub', $newsletterSub);
        $user->setBooleanField('pledged', $pledged);
        
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
