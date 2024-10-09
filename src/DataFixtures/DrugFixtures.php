<?php

namespace App\DataFixtures;

use App\Entity\Drug;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Uid\Uuid;

class DrugFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $drugName = [
            'Paracetamol', 'Ibuprofen', 'Aspirin', 'Amoxicillin',
            'Ciprofloxacin', 'Metformin', 'Lisinopril', 'Atorvastatin',
            'Omeprazole', 'Simvastatin'
        ];

        for ($i = 0; $i < count($drugName); $i++) {
            $drug = new Drug();

            // Générer un GUID pour CIS avec Uuid
            $drug->setCIS(Uuid::v4()->toRfc4122());

            // Utiliser des noms de médicaments fixes
            $drug->setName($drugName[$i]);
            $drug->setDosage('100mg');
            $drug->setIndication('Indication for ' . $drugName[$i]);
            $drug->setContraindication('Contraindication for ' . $drugName[$i]);
            $drug->setSecondaryEffect('Secondary effect for ' . $drugName[$i]);

            $manager->persist($drug);
        }

        $manager->flush();
    }
}
