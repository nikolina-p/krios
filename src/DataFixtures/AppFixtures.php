<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $surnames = ['Pavkovic', "Karajcic", "Mostarac", 'Loncar', 'Stegic', 'Boskovic', 'Jocic', 'Jovanovic', 'Stefanovic',
            'Nikolic', 'Markovic', 'Antic', 'Vukovic', 'Prefer', 'Mihajlovic', 'Prodanovic Stojanovic', 'Milovanovic Sretenovic'];
        $names = ['Maja'=>'FEMALE', 'Jovan'=>'MALE', 'Sanja'=>'FEMALE', 'Aleksandar'=>'MALE', 'Nikola'=>'MALE',
            'Marija'=>'FEMALE', 'Ivana'=>'FEMALE', 'Milos'=>'MALE', 'Ivan'=>'MALE', 'Goran'=>'MALE', 'Zoran'=>'MALE',
            'Ilija'=>'MALE', 'Marko'=>'MALE', 'Marija Ana'=>'FEMALE', 'Jelena'=>'FEMALE', 'Marija Ilena'=>'FEMALE'];

        for($i = 0; $i<200; $i++) {
            $patient = new Patient();
            $name = array_rand($names);

            $patient->setName($name);
            $patient->setSurname($surnames[array_rand($surnames)]);
            $patient->setEmail($name.'@gmail.com');
            $patient->setGender($names[$name]);
            $patient->setPhone('+38167'.rand(100000,999999));

            $patient->setRegistrationDate(
                $this->getRandomDate('Nov-01-2015', 'Dec-31-2018')
            );

            $manager->persist($patient);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }

    private function getRandomDate(string $startDate, string $endDate)
    {
        $timestampStart = strtotime($startDate);
        $timestampEnd = strtotime($endDate);

        $randomTimestamp = mt_rand($timestampStart, $timestampEnd);

        $randomDate = new \DateTime();
        $randomDate->setTimestamp($randomTimestamp);

        return $randomDate;
    }
}
