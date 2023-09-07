<?php

namespace App\DataFixtures;

use App\Entity\System;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SystemFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = [
            "Playstation",
            "PC",
            "XBOX",
            "Nintendo Switch"
        ];

        foreach ($names as $name) {
            // Je crée des objets tags et les remplie
            // avant d'en demander l'enregistrement à l'ObjectManager
            $system = new System();
            $system->setName($name);
            $manager->persist($system);
        }
        // On sauvegarde effectivement tout en base
        $manager->flush();
    }

}