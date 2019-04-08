<?php

namespace App\DataFixtures;

use App\Entity\Patient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $patient = new Patient();
        $patient->setName('Mika');
        $patient->setSurname('Stefanovic');
        $patient->setEmail('mika#gmail.com');
        $patient->setGender('MALE');
        $patient->setPhone('+38167123456');

        $manager->persist($patient);

        $manager->flush();
    }
}
