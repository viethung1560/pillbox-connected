<?php

namespace App\DataFixtures;

use App\Entity\Treatment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TreatmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Générer 10 traitements
        for ($i = 1; $i <= 10; $i++) {
            $treatment = new Treatment();
            $treatment->setFrequency($faker->randomElement([1, 2, 3])); // 1 à 3 fois par jour
            $treatment->setLastTakingTime($faker->dateTimeBetween('-1 days', 'now')); // Dernière prise dans les 24 heures

            $manager->persist($treatment);

            // Ajouter une référence pour lier avec TreatmentTime et MedecineBox
            $this->addReference('treatment_' . $i, $treatment);
        }

        $manager->flush();
    }
}
