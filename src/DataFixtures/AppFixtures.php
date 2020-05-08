<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\CustomPledge;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_US');

        for ($i = 0; $i < 50; $i++) {
            $gender = (($i % 2) == 0 ? 'male' : 'female');
            $firstName = $faker->firstName($gender);
            $lastName = $faker->lastName;

            $userPledge = new CustomPledge();
            $userPledge->setFirstName($firstName);
            $userPledge->setLastName($lastName);
            $userPledge->setBody("Sample custom pledge");
            $userPledge->setLikeCount(($i % 2) == 0 ? 10 : 0);
            $userPledge->setApproved(($i % 2) == 0);
            $userPledge->setCanShare(($i % 2) == 0);

            $manager->persist($userPledge);

            $user = new User();
            $user->setStringField('firstName', $firstName);
            $user->setStringField('lastName', $lastName);
            $user->setStringField('email', $faker->email);
            $user->setStringField('zipcode', $faker->postcode);
            $user->setStringField('organization', $faker->company);
            $user->setBooleanField('newsletterSub', true);
            $user->setBooleanField('shareOnMedia', true);
            $user->setBooleanField('pledged', true);
            $user->setUserPledge($userPledge);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
