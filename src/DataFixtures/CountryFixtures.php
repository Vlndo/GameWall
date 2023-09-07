<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = [
            "Afghanistan",
            "Afrique du Sud",
            "Albanie",
            "Algérie",
            "Allemagne",
            "Andorre",
            "Angola",
            "Anguilla",
            "Antarctique",
            "Antigua-et-Barbuda",
            "Antilles néerlandaises",
            "Arabie saoudite",
            "Argentine",
            "Arménie",
            "Aruba",
            "Australie",
            "Autriche",
            "Azerbaïdjan",
            "Bahamas",
            "Bahreïn",
            "Bangladesh",
            "Barbade",
            "Bélarus",
            "Belgique",
            "France",
        ];

        foreach ($names as $name) {
            // Je crée des objets tags et les remplie
            // avant d'en demander l'enregistrement à l'ObjectManager
            $country = new Country();
            $country->setName($name);
            $manager->persist($country);
        }
        // On sauvegarde effectivement tout en base
        $manager->flush();
    }

}