<?php

namespace App\DataFixtures;

use App\Entity\Interim;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 1; $i <= 20; $i++) {
            $interim = new Interim();

            $zipCode1 = mt_rand(0,9);
            $zipCode2 = mt_rand(1,9);
            $zipCode3 = mt_rand(0,9);
            $zipCode = $zipCode1 . $zipCode2 . $zipCode3 . "00";

            $interim
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName)
                ->setZipCode($zipCode);

            $manager->persist($interim);
        }

        $manager->flush();
    }
}
