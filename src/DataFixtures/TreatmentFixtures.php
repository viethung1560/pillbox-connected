<?php

namespace App\DataFixtures;

use App\Entity\MedecineBox;
use App\Entity\Treatment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TreatmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $medecineBoxs = $manager->getRepository(MedecineBox::class)->findAll();

        foreach ($medecineBoxs as $medecineBox) {
            $treatment = new Treatment();
            $treatment->setMedecineBox($medecineBox);
            $treatment->setCompartement($faker->numberBetween(1, 2));
            $treatment->setFrequency($faker->randomElement([1, 2, 3])); // 1 à 3 fois par jour
            $treatment->setLastTakingTime($faker->dateTimeBetween('-1 days', 'now')); // Dernière prise dans les 24 heures

            $manager->persist($treatment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            MedecineBoxFixtures::class, // Assurer que DrugFixtures soit chargée avant
        ];
    }
}
