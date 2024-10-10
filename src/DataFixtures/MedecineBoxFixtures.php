<?php

namespace App\DataFixtures;

use App\Entity\Drug;
use App\Entity\MedecineBox;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MedecineBoxFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Liste des noms de médicaments associés à des noms de boîtes
        $drugToBoxName = [
            'Paracetamol'    => 'Doliprane',
            'Ibuprofen'      => 'Advil',
            'Aspirin'        => 'Aspégic',
            'Amoxicillin'    => 'Clamoxyl',
            'Ciprofloxacin'  => 'Ciflox',
            'Metformin'      => 'Glucophage',
            'Lisinopril'     => 'Prinivil',
            'Atorvastatin'   => 'Tahor',
            'Omeprazole'     => 'Mopral',
            'Simvastatin'    => 'Zocor',
        ];

        // Boucle pour générer des MedecineBox en fonction des médicaments
        foreach ($drugToBoxName as $drugName => $boxName) {
            // Récupérer la référence du médicament correspondant
            $drug = $manager->getRepository(Drug::class)->findOneBy(['name' => $drugName]);

            if ($drug) {
                $medecineBox = new MedecineBox();

                // Associer le médicament à la MedecineBox
                $medecineBox->setDrug($drug);

                // Assigner un nom de boîte spécifique
                $medecineBox->setName($boxName);

                // Générer des données supplémentaires avec Faker
                $medecineBox->setExpirationDate($faker->dateTimeBetween('now', '+2 years')); // Date d'expiration future
                $medecineBox->setConditioning($faker->numberBetween(20, 60)); // Types de conditionnement
                $medecineBox->setPrice($faker->randomFloat(2, 5, 100)); // Prix entre 5 et 100 euros
                $medecineBox->setManufacturer($faker->company); // Nom d'un fabricant fictif

                $manager->persist($medecineBox);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DrugFixtures::class, // Assurer que DrugFixtures soit chargée avant
            TreatmentFixtures::class,
        ];
    }
}
