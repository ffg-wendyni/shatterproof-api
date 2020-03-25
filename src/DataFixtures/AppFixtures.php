<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Location;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_US');

        for ($i = 0; $i < 50; $i++) {
            $location = new Location();
            $location->setStringField('street1', $faker->streetAddress);
            $location->setStringField('state', $faker->state);
            $location->setStringField('country', $faker->country);
            $location->setStringField('zipcode', $faker->postcode);
            $manager->persist($location);

            $gender = (($i % 2) == 0 ? 'male' : 'female');
            $user = new User();
            $user->setStringField('firstName', $faker->firstName($gender));
            $user->setStringField('lastName', $faker->lastName);
            $user->setStringField('email', $faker->email);
            $user->setStringField('phone', $faker->numerify('##########'));
            $user->setStringField('gender', 'Male');
            $user->setDateField('dob', $faker->DateTime('now', 'UTC'));
            $user->setStringField('ethnicity', 'Human');
            $user->setStringField('occupation', $faker->jobTitle);
            $user->setStringField('organization', $faker->company);
            $user->setBooleanField('newsletterSub', true);
            $user->setBooleanField('textAlertSub', true);
            $user->setBooleanField('shareOnMedia', true);
            $user->setBooleanField('pledged', true);
            $user->setStringField('customPledgeLink', 'www.sampletext.com');
            $user->setLocation($location);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
