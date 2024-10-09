<?php

namespace App\DataFixtures;

use App\Entity\Treatment;
use App\Entity\TreatmentTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TreatmentTimeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Les heures spécifiques disponibles
        $possibleTimes = ['08:00:00', '13:00:00', '19:00:00'];

        $treatments = $manager->getRepository(Treatment::class)->findAll();

        // Générer des heures de traitement pour les 10 traitements
        foreach ($treatments as $treatment) {
            // Récupérer la référence du traitement
            $frequency = $treatment->getFrequency(); // Obtenir la fréquence du traitement

            // Créer un nombre de `TreatmentTime` égal à la fréquence
            for ($j = 0; $j < $frequency; $j++) {
                $treatmentTime = new TreatmentTime();

                // Choisir une heure aléatoire parmi 08:00, 13:00 et 19:00
                $randomTime = $possibleTimes[array_rand($possibleTimes)];
                $treatmentTime->setTime(new \DateTime($randomTime));

                $manager->persist($treatmentTime);
                // Associer ce `TreatmentTime` au `Treatment`
                $treatment->addTreatmentTime($treatmentTime);
                dump($treatment);

                // Persist de `TreatmentTime`
            }

            // Persist le traitement avec ses heures
            $manager->persist($treatment);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            TreatmentFixtures::class,
        ];
    }
}
