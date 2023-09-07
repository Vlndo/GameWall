<?php

namespace App\DataFixtures;

use App\Entity\Paiment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaimentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = [
            "Paypal",
            "Credit/Debit card",
            "ApplePay",
            "PaySafeCard",
        ];

        foreach ($names as $name) {
            // Je crée des objets tags et les remplie
            // avant d'en demander l'enregistrement à l'ObjectManager
            $paiment = new Paiment();
            $paiment->setName($name);
            $manager->persist($paiment);
        }
        // On sauvegarde effectivement tout en base
        $manager->flush();
    }

}