<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_US');

        for ($i = 0; $i < 50; $i++) {
            $gender = (($i % 2) == 0 ? 'male' : 'female');
            $user = new User();
            $user->setStringField('firstName', $faker->firstName($gender));
            $user->setStringField('lastName', $faker->lastName);
            $user->setStringField('email', $faker->email);
            $user->setStringField('zipcode', $faker->postcode);
            $user->setStringField('organization', $faker->company);
            $user->setBooleanField('newsletterSub', true);
            $user->setBooleanField('shareOnMedia', true);
            $user->setBooleanField('pledged', true);
            $user->setStringField('customPledgeLink', 'www.sampletext.com');
            $manager->persist($user);
        }

        $manager->flush();
    }
}
